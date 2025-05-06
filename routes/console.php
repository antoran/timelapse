<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:capture-rtsp')->everyFiveSeconds()
    ->runInBackground()
    ->appendOutputTo(storage_path('logs/rtsp_capture.log'));

Schedule::command('app:generate-daily-timelapse-videos')
    ->dailyAt('00:00')
    ->runInBackground()
    ->appendOutputTo(storage_path('logs/rtsp_video.log'));
