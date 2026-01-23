<?php

namespace App\Filament\University\Resources\ApplicationResource\Pages;

use App\Filament\University\Resources\ApplicationResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewApplication extends ViewRecord
{
    protected static string $resource = ApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [

            // قبول الطلب
            Actions\Action::make('accept')
                ->label('قبول الطلب')
                ->color('success')
                ->visible(fn () => $this->record->status === 'UNDER_REVIEW')
                ->action(fn () => $this->record->accept()),

            // رفض الطلب
            Actions\Action::make('reject')
                ->label('رفض الطلب')
                ->color('danger')
                ->form([
                    \Filament\Forms\Components\Textarea::make('reason')
                        ->label('سبب الرفض')
                        ->required(),
                ])
                ->visible(fn () => in_array($this->record->status, ['SUBMITTED','UNDER_REVIEW']))
                ->action(function (array $data) {
                    $this->record->reject($data['reason']);
                }),
        ];
    }
}