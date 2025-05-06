<?php

namespace App\Jobs;

use App\Actions\CreateImageFromRTSPStream;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CaptureImage implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    public int $uniqueFor = 5;

    public function __construct(
        protected string $rtspStream,
    )
    {}

    public function handle(CreateImageFromRTSPStream $action): void
    {
        $action->execute();
    }
}
