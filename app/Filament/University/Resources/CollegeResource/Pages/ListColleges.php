<?php

namespace App\Filament\University\Resources\CollegeResource\Pages;

use App\Filament\University\Resources\CollegeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListColleges extends ListRecords
{
    protected static string $resource = CollegeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
