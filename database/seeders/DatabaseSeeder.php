<?php

namespace Database\Seeders;

use App\Models\Feed;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'daniel@danweb.design',
            'password' => bcrypt('password'),
        ]);

        Feed::create([
            'name' => 'Test Feed',
            'rtsp_url' => 'rtsp://100.123.74.38:8554/stream',
        ]);
    }
}
