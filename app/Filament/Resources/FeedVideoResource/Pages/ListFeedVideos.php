<?php

namespace App\Filament\Resources\FeedVideoResource\Pages;

use App\Filament\Resources\FeedVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFeedVideos extends ListRecords
{
    protected static string $resource = FeedVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
