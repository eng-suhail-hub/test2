<?php

namespace App\Filament\University\Resources\CollegeResource\Pages;

use App\Filament\University\Resources\CollegeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCollege extends EditRecord
{
    protected static string $resource = CollegeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
