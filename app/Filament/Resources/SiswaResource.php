<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Filament\Resources\SiswaResource\RelationManagers;
use App\Models\LevelSiswa;
use App\Models\Siswa;
use App\Models\SiswaKelas;
use App\Models\SiswaKelasSemester;
use App\Models\SiswaKelasSemesterSpp;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Actions;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\DB;

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
                Grid::make(2)->schema([
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
                    Forms\Components\TextInput::make('nis')
                ]),
                Grid::make(1)->schema([
                    Forms\Components\Repeater::make('student_classes')
                        ->schema([
                            Forms\Components\Select::make('level_id')
                                ->relationship('levels', 'name')
                                ->label('Level')
                                ->required(),
                            Forms\Components\Select::make('school_year_id')
                                ->relationship('schoolYears', 'start_year')
                                ->label('Tahun ajaran')
                                ->required(),
                            Forms\Components\Select::make('kelas_id')
                                ->relationship('classes', 'name')
                                ->label('Kelas')
                                ->required(),
                            Forms\Components\Select::make('kelas_category_id')
                                ->relationship('classCategories', 'name')
                                ->label('Kategori Kelas')
                                ->required(),
                        ])
                        ->minItems(1)
                        ->label('Masukkan kelas')
                        ->createItemButtonLabel('Tambah Kelas'),
                ])
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        DB::beginTransaction();
        try {
            // Insert into `students` table
            $student = Siswa::create([
                'name' => $data['name'],
                'date_of_birth' => $data['date_of_birth'],
                'place_of_birth' => $data['place_of_birth'],
                'mother_name' => $data['mother_name'],
                'father_name' => $data['father_name'],
                'gender' => $data['gender'],
                'nis' => $data['nis'],
            ]);

            // Insert into multiple related tables from the Repeater data
            foreach ($data['student_class'] as $classData) {
                // Insert into `student_class`
                $studentClass = SiswaKelas::create([
                    'student_id' => $student->id,
                    'school_year_id' => $classData['school_year_id'],
                    'class_category_id' => $classData['class_category_id'],
                    'level_id' => $classData['level_id'],
                    'class_id' => $classData['class_id'],
                ]);

                // Insert into `level_student`
                LevelSiswa::create([
                    'student_id' => $student->id,
                    'level_id' => $classData['level_id'],
                ]);

                // Insert into `student_class_semester`
                $studentClassSemester = SiswaKelasSemester::create([
                    'student_class_id' => $studentClass->id,
                    'semester' => 1, // Example: Set semester dynamically if needed
                ]);

                // Insert into `student_class_semester_spp`
                SiswaKelasSemesterSpp::create([
                    'student_class_semester_id' => $studentClassSemester->id,
                    'spp_amount' => 1000000, // Example: Set default SPP fee
                ]);
            }

            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama Lengkap')->limit(30)
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->label('Tanggal Lahir'),
                Tables\Columns\TextColumn::make('mother_name')
                    ->label('Nama Ibu'),
                Tables\Columns\TextColumn::make('father_name')
                    ->label('Nama Ayah'),
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
