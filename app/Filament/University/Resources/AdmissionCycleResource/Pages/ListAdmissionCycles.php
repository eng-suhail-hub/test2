<?php

namespace App\Filament\University\Resources\AdmissionCycleResource\Pages;

use App\Filament\University\Resources\AdmissionCycleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdmissionCycles extends ListRecords
{
    protected static string $resource = AdmissionCycleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
