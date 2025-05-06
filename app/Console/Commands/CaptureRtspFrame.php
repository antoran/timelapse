<?php

namespace App\Console\Commands;

use App\Models\Feed;
use RuntimeException;
use Illuminate\Console\Command;
use App\Actions\CreateImageFromRTSPStream;
use Illuminate\Support\Facades\Concurrency;

class CaptureRtspFrame extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:capture-rtsp-frame';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Capture a frame from an RTSP stream and save as an image';

    /**
     * Execute the console command.
     */
    public function handle(CreateImageFromRTSPStream $createImageFromRTSP): int
    {
        $feeds = Feed::all();
        
        $closures = $feeds->map(fn ($feed) => fn () => $createImageFromRTSP->execute($feed))->toArray();
        try {
            Concurrency::driver('fork')->run(
                $closures
            );
        } catch (RuntimeException $e) {
            $this->error('Failed to create image from RTSP stream: ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
