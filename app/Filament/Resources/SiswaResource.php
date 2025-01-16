<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Filament\Resources\SiswaResource\RelationManagers;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Actions;


class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected static ?string $navigationLabel = 'Siswa';

    protected static ?string $navigationGroup = "Master data";
    // another side for change breadcrumb
    // protected static ?string $modelLabel = 'Siswasss';


    // breadcrumb change
    public static function getPluralModelLabel(): string
    {
        return 'List siswa';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\DatePicker::make('date_of_birth'),
                Forms\Components\TextInput::make('place_of_birth'),
                Forms\Components\TextInput::make('mother_name'),
                Forms\Components\TextInput::make('father_name'),
                Forms\Components\Select::make('gender')
                    ->options([
                        'l' => "Laki-laki",
                        'p' => "Perempuan"
                    ]),
                Forms\Components\TextInput::make('nis'),
                Forms\Components\Repeater::make('kelas')->label('Kelas')
                    ->relationship('kelas')
                    ->schema([
                        Forms\Components\Select::make('level_id')
                            // ->relationship('listLevel', 'name')
                            ->placeholder('Pilih level sekolah')
                            ->label('Level Sekolah')
                            ->required(),
                        Forms\Components\TextInput::make('kelas_category_id')
                            ->label('Nama Kelas Kategori')
                            ->placeholder("Pilih kategori kelas")
                            ->required(),
                    ])
                    ->minItems(1)
                    ->createItemButtonLabel('Tambah Kelas Kategori'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama Lengkap')->limit(30)
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')->label('Tanggal Lahir'),
                Tables\Columns\TextColumn::make('mother_name')->label('Nama Ibu'),
                Tables\Columns\TextColumn::make('father_name')->label('Nama Ayah'),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('nis'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Ubah'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
