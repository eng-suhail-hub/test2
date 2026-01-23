<?php

namespace App\Filament\Resources\AdmissionCycleResource\Pages;

use App\Filament\Resources\AdmissionCycleResource;
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
