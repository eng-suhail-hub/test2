<?php

namespace App\Filament\University\Resources\CollegeMajorResource\Pages;

use App\Filament\University\Resources\CollegeMajorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCollegeMajors extends ListRecords
{
    protected static string $resource = CollegeMajorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
