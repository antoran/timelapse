<?php

use App\Models\Feed;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feed_images', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Feed::class)->constrained();
            $table->string('disk');
            $table->string('path');
            $table->timestamp('image_taken_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feed_images');
    }
};
