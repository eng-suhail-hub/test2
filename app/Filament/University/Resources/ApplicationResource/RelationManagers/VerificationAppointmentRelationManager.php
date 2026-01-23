<?php

namespace App\Filament\University\Resources\ApplicationResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;

class VerificationAppointmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'verificationAppointments';
    protected static ?string $title = 'مواعيد الحضور';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\DateTimePicker::make('appointment_at')
                ->label('موعد الحضور')
                ->required(),

            Forms\Components\Textarea::make('notes')
                ->label('ملاحظات')
                ->nullable(),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('appointment_at')
                    ->label('الموعد')
                    ->dateTime(),

                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة'),

                Tables\Columns\TextColumn::make('notes')
                    ->label('ملاحظات')
                    ->wrap(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}