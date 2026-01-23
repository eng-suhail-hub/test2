<?php

namespace App\Filament\University\Resources\ApplicationResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;

class ApplicationRejectionRelationManager extends RelationManager
{
    protected static string $relationship = 'rejection';
    protected static ?string $title = 'سبب الرفض';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reason')
                    ->label('سبب الرفض')
                    ->wrap(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الرفض')
                    ->dateTime(),
            ]);
    }
}