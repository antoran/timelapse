<?php

namespace App\Jobs;

use App\Actions\CreateImageFromRTSPStream;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CaptureImage implements ShouldBeUnique, ShouldQueue
{
    use Queueable;

    public int $uniqueFor = 5;

    public function __construct(
        protected string $rtspStream,
    ) {}

    public function handle(CreateImageFromRTSPStream $action): void
    {
        $action->execute();
    }
}
