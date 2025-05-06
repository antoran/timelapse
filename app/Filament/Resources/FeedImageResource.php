<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeedImageResource\Pages;
use App\Models\FeedImage;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Table;

class FeedImageResource extends Resource
{
    protected static ?string $model = FeedImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    Tables\Columns\ImageColumn::make('imageUrl')
                        ->label('Image')
                        ->size('100%')
                        ->circular(false),
                    Tables\Columns\TextColumn::make('feed.name')
                        ->label('Feed Name')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('created_at')
                        ->label('Created At')
                        ->dateTime()
                        ->sortable()
                        ->dateTime()
                        ->sortable(),
                ]),
            ])
            ->contentGrid([
                'sm' => 2,
                'lg' => 3,
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListFeedImages::route('/'),
            // 'create' => Pages\CreateFeedImage::route('/create'),
            'view' => Pages\ViewFeedImage::route('/{record}'),
            // 'edit' => Pages\EditFeedImage::route('/{record}/edit'),
        ];
    }
}
