<?php
namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListSiswas extends ListRecords
{
    protected static string $resource = SiswaResource::class;

    // ✅ Change to public (required by Filament 3)
    public function getTitle(): string|Htmlable
    {
        return 'Daftar Siswa'; // Change this title as needed
    }

    public function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah siswa'),
        ];
    }
}
