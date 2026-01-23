<?php

namespace App\Filament\University\Resources\AdmissionCycleResource\Pages;

use App\Filament\University\Resources\AdmissionCycleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdmissionCycle extends EditRecord
{
    protected static string $resource = AdmissionCycleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
