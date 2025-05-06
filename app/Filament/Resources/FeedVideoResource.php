<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeedVideoResource\Pages;
use App\Filament\Resources\FeedVideoResource\RelationManagers;
use App\Models\FeedVideo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FeedVideoResource extends Resource
{
    protected static ?string $model = FeedVideo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('videoUrl')
                    ->label('Video')
                    ->size('100%')
                    ->circular(false),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeedVideos::route('/'),
            // 'create' => Pages\CreateFeedVideo::route('/create'),
            'view' => Pages\ViewFeedVideo::route('/{record}'),
            // 'edit' => Pages\EditFeedVideo::route('/{record}/edit'),
        ];
    }
}
