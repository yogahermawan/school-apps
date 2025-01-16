<?php

namespace App\Filament\Resources\LevelResource\Pages;

use App\Filament\Resources\LevelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;


class ListLevels extends ListRecords
{
    protected static string $resource = LevelResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Daftar Level';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah level'),
        ];
    }


}
