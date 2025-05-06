<?php

namespace App\Console\Commands;

use App\Actions\CreateTimelapseVideo;
use App\Models\Feed;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Concurrency;
use Illuminate\Support\Facades\Date;
use RuntimeException;

class GenerateDailyTimelapseVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-daily-timelapse-videos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate timelapse videos for all feeds for the previous day.';

    /**
     * Execute the console command.
     */
    public function handle(CreateTimelapseVideo $action): int
    {
        $date = Date::yesterday();
        $feeds = Feed::all();

        $closures = $feeds->map(fn ($feed) => fn () => $action->execute($feed, $date))->toArray();
        try {
            Concurrency::driver('fork')->run(
                $closures
            );
        } catch (RuntimeException $e) {
            $this->error('Failed to create timelapse videos: '.$e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
