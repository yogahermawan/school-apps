<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SchoolYearResource\Pages;
use App\Filament\Resources\SchoolYearResource\RelationManagers;
use App\Models\SchoolYear;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class SchoolYearResource extends Resource
{
    protected static ?string $model = SchoolYear::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('start_year')
                    ->label('Tahun Awal Ajaran')
                    ->options(
                        array_combine(range(date('Y'), 2000), range(date('Y'), 2000))
                    )
                    ->searchable()
                    ->required()
                    ->reactive(),
                Forms\Components\Select::make('end_year')
                    ->label('Tahun Akhir Ajaran')
                    ->options(
                        array_combine(range(date('Y') + 1, 2000), range(date('Y') + 1, 2000))
                    )
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(
                        fn(Set $set, Get $get, $state) =>
                        // Prevent end_year from being smaller than start_year
                        $set('end_year', max($get('start_year') + 1, $state))
                    ),
                Forms\Components\Repeater::make('kelas_school_year')
                    ->schema([
                        Forms\Components\Select::make('kelas_id')
                            ->relationship('classes', 'name')
                            ->label('Pilih kelas')
                            ->required(),
                        Forms\Components\TextInput::make('spp')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('dsp')->required(),
                        Forms\Components\TextInput::make('kegiatan_akhir_tahun')->required(),
                        Forms\Components\TextInput::make('uang_buku')->required(),
                    ])
                    ->minItems(1)
                    ->label('Tambah tagihan tahunan')
                    ->createItemButtonLabel('Tambah Kelas'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('start_year')
                    ->label('Tahun Awal Ajaran'),
                Tables\Columns\TextColumn::make('end_year')
                    ->label('Tahun Akhir Ajaran'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal dibuat'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Tanggal diubah'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSchoolYears::route('/'),
            'create' => Pages\CreateSchoolYear::route('/create'),
            'edit' => Pages\EditSchoolYear::route('/{record}/edit'),
        ];
    }
}
