<?php

namespace App\Filament\Resources\BookResource\Pages;

use App\Filament\Resources\BookResource;
use App\Models\Book;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditBook extends EditRecord
{
    protected static string $resource = BookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->after(function (Book $record) {
                    // delete single
                    if ($record->cover_image) {
                        Storage::disk('public')->delete($record->cover_image);
                    }
                }),
        ];
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->after(function (Book $record) {
                    // delete single
                    if ($record->cover_image) {
                        Storage::disk('public')->delete($record->cover_image);
                    }
                }),
        ];
    }
}
