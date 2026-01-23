<?php

namespace App\Filament\University\Resources\CollegeMajorResource\Pages;

use App\Filament\University\Resources\CollegeMajorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCollegeMajor extends EditRecord
{
    protected static string $resource = CollegeMajorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
