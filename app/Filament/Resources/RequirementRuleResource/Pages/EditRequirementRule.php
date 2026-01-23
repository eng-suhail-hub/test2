<?php

namespace App\Filament\Resources\RequirementRuleResource\Pages;

use App\Filament\Resources\RequirementRuleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRequirementRule extends EditRecord
{
    protected static string $resource = RequirementRuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
