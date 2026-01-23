<?php

namespace App\Filament\Resources\RequirementAssignmentResource\Pages;

use App\Filament\Resources\RequirementAssignmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRequirementAssignment extends EditRecord
{
    protected static string $resource = RequirementAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
