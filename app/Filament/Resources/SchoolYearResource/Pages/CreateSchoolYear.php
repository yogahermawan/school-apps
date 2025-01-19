<?php

namespace App\Filament\Resources\SchoolYearResource\Pages;

use App\Filament\Resources\SchoolYearResource;
use App\Models\SchoolYear;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateSchoolYear extends CreateRecord
{
    protected static string $resource = SchoolYearResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        DB::beginTransaction();
        try {
            // Insert school_year
            $schoolYear = SchoolYear::create([
                'start_year' => $data['start_year'],
                'end_year' => $data['end_year'],
            ]);

            // Insert related data
            if (!empty($data['kelas_school_year'])) {
                foreach ($data['kelas_school_year'] as $kelasData) {
                    DB::table('kelas_school_year')->insert([
                        'school_year_id' => $schoolYear->id,
                        'kelas_id' => $kelasData['kelas_id'],
                        'spp' => $kelasData['spp'],
                        'dsp' => $kelasData['dsp'],
                        'kegiatan_akhir_tahun' => $kelasData['kegiatan_akhir_tahun'],
                        'uang_buku' => $kelasData['uang_buku'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();
            return $schoolYear;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
