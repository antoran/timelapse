<?php

namespace App\Filament\Resources\FeedImageResource\Pages;

use App\Filament\Resources\FeedImageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFeedImages extends ListRecords
{
    protected static string $resource = FeedImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
