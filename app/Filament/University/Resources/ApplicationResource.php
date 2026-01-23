<?php

namespace App\Filament\University\Resources;

use App\Filament\University\Resources\ApplicationResource\Pages;
use App\Filament\University\Resources\ApplicationResource\RelationManagers;
use App\Models\Application;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'طلبات التقديم';
    protected static ?string $pluralModelLabel = 'طلبات التقديم';
    protected static ?string $navigationGroup = 'القبول والتسجيل';

    /**
     * 🔐 عرض طلبات الجامعة فقط
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('collegeMajor.college', function ($q) {
                $q->where('university_id', auth()->user()->university()->id);
            })
            ->whereIn('status', ['SUBMITTED', 'UNDER_REVIEW', 'ACCEPTED', 'REJECTED']);
    }

    /**
     * 📋 لا يوجد create/edit مباشر
     */
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('student.full_name')
                    ->label('الطالب')
                    ->searchable(),

                Tables\Columns\TextColumn::make('collegeMajor.major.name')
                    ->label('التخصص'),

                Tables\Columns\TextColumn::make('collegeMajor.college.name')
                    ->label('الكلية'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('الحالة')
                    ->colors([
                        'gray' => 'SUBMITTED',
                        'warning' => 'UNDER_REVIEW',
                        'success' => 'ACCEPTED',
                        'danger' => 'REJECTED',
                        'info' => 'VERIFIED',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ التقديم')
                    ->dateTime(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\VerificationAppointmentsRelationManager::class,
            RelationManagers\ApplicationRejectionRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplications::route('/'),
            'view'  => Pages\ViewApplication::route('/{record}'),
        ];
    }
}