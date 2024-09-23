<?php

namespace App\Filament\Resources\SuratkeputusanResource\Pages;

use App\Filament\Resources\SuratkeputusanResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSuratkeputusans extends ManageRecords
{
    protected static string $resource = SuratkeputusanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
