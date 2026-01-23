<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudyTypeResource\Pages;
use App\Filament\Resources\StudyTypeResource\RelationManagers;
use App\Models\StudyType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudyTypeResource extends Resource
{
    protected static ?string $model = StudyType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'انواع الدراسة';
    protected static ?string $pluralModelLabel = 'انواع الدراسة';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                        ->label('اسم نوع الدراسة')
                        ->required(),

                    Forms\Components\TextInput::make('code')
                        ->label('رمز نوع الدراسة')
                        ->required()
                        ->unique(ignoreRecord: true),

                   Forms\Components\Textarea::make('description')
                        ->label('الوصف')
                        ->columnSpanFull(),

                    Forms\Components\Toggle::make('is_active')
                        ->label('مفعل')
                        ->default(true),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
Tables\Columns\TextColumn::make('name')
                    ->label('نوع الدراسة')
                    ->searchable(),

                Tables\Columns\TextColumn::make('code')
                    ->label('الرمز'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('الحالة')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudyTypes::route('/'),
            'create' => Pages\CreateStudyType::route('/create'),
            'edit' => Pages\EditStudyType::route('/{record}/edit'),
        ];
    }
}
