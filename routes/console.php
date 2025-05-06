<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:capture-rtsp')->everyFiveSeconds()
    ->runInBackground()
    ->appendOutputTo(storage_path('logs/rtsp_capture.log'));
