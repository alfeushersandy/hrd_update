<?php

namespace App\Filament\Resources\KaryawankeluarResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\KaryawankeluarResource;
use App\Models\Karyawan;

class ManageKaryawankeluars extends ManageRecords
{
    protected static string $resource = KaryawankeluarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->using(function (array $data, string $model): Model {
                    $keluar = $model::create($data);

                    $karyawan = Karyawan::find($data['karyawans_id']);

                    $karyawan->update([
                        'is_active' => false
                    ]);

                    return $keluar;
                }),
        ];
    }
}
