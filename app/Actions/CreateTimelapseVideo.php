<?php

namespace App\Actions;

use App\Models\Feed;
use App\Models\FeedImage;
use App\Models\FeedVideo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateTimelapseVideo
{
    /**
     * Generate a timelapse video for a given feed and date.
     *
     * @param  string|Carbon  $date  (Y-m-d or Carbon)
     */
    public function execute(Feed $feed, $date): ?FeedVideo
    {
        $date = $date instanceof Carbon ? $date : Carbon::parse($date);
        $images = FeedImage::where('feed_id', $feed->id)
            ->whereDate('image_taken_at', $date->toDateString())
            ->orderBy('image_taken_at')
            ->get();

        if ($images->isEmpty()) {
            return null;
        }

        // Download images to a temp directory
        $tmpDir = storage_path('app/tmp/timelapse_'.Str::random(8));
        if (! is_dir($tmpDir)) {
            mkdir($tmpDir, 0777, true);
        }

        $imageFiles = [];
        foreach ($images as $i => $image) {
            $imgPath = $tmpDir.'/'.sprintf('%05d.jpg', $i);
            $content = Storage::disk($image->disk)->get($image->path);
            file_put_contents($imgPath, $content);
            $imageFiles[] = $imgPath;
        }

        // Generate video using ffmpeg
        $videoFilename = 'timelapse_'.$feed->id.'_'.$date->format('Ymd').'.mp4';
        $videoPath = $tmpDir.'/'.$videoFilename;
        $ffmpegCmd = "ffmpeg -y -framerate 24 -pattern_type glob -i '$tmpDir/*.jpg' -c:v libx264 -pix_fmt yuv420p '$videoPath'";
        exec($ffmpegCmd, $output, $returnVar);

        if ($returnVar !== 0 || ! file_exists($videoPath)) {
            Log::error('Timelapse video generation failed', ['cmd' => $ffmpegCmd, 'output' => $output]);
            // Cleanup
            array_map('unlink', glob("$tmpDir/*.jpg"));
            rmdir($tmpDir);

            return null;
        }

        // Store video in storage (e.g., public disk)
        $storageDisk = 'public';
        $storagePath = 'feed_videos/'.$videoFilename;
        Storage::disk($storageDisk)->put($storagePath, file_get_contents($videoPath));

        // Cleanup temp files
        array_map('unlink', glob("$tmpDir/*.jpg"));
        unlink($videoPath);
        rmdir($tmpDir);

        // Create FeedVideo record
        $feedVideo = FeedVideo::create([
            'feed_id' => $feed->id,
            'disk' => $storageDisk,
            'path' => $storagePath,
        ]);

        return $feedVideo;
    }
}
