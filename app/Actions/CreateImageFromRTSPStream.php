<?php
declare(strict_types=1);
namespace App\Actions;

use App\Models\Feed;
use RuntimeException;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

/**
 * Class CreateImageFromRTSP
 *
 * This class is responsible for creating an image from an RTSP stream using FFmpeg.
 */
class CreateImageFromRTSPStream
{
    /**
     * Execute the action to create an image from the RTSP stream.
     *
     * @return bool
     * @throws RuntimeException
     */
    public function execute(
        Feed $feed,
        int $width = 1920,
        int $height = 1080,
        string $disk = 'local'
    ): string
    {
        $tempPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('frame_', true) . '.png';
        $now = now();

        $filename = str("{$feed->name}-{$now->format('Y-m-d_H-i-s')}.png")
            ->replace(' ', '_')
            ->toString();


        $result = Process::run([
            'ffmpeg',
            '-i', $feed->rtsp_url,
            '-vf', "scale={$width}:{$height}",
            '-vframes', '1',
            $tempPath,
        ]);

        if ($result->failed()) {
            throw new RuntimeException($result->exitCode() .  ': Failed to create image from RTSP stream: ' . $result->errorOutput());
        }

        $fs = Storage::disk($disk);

        $fs->put($filename, file_get_contents($tempPath));

        $feed->images()->create([
            'disk' => $disk,
            'path' => $filename,
            'image_taken_at' => $now,
        ]);

        // Optionally delete the temporary file
        if (file_exists($tempPath)) {
            unlink($tempPath);
        }

        // Return the path to the stored image
        return $fs->path($filename);
    }
}