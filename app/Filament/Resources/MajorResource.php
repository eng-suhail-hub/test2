<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MajorResource\Pages;
use App\Models\Major;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MajorResource extends Resource
{
    protected static ?string $model = Major::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'التخصصات العامة';
    protected static ?string $pluralModelLabel = 'التخصصات';
    protected static ?string $navigationGroup = 'البيانات الأساسية';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('تعريف التخصص')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('اسم التخصص')
                        ->required(),

                    Forms\Components\TextInput::make('code')
                        ->label('رمز التخصص')
                        ->required()
                        ->unique(ignoreRecord: true),

                 /**   Forms\Components\Textarea::make('description')
                        ->label('الوصف')
                        ->columnSpanFull(),**/

                    Forms\Components\Toggle::make('is_active')
                        ->label('مفعل')
                        ->default(true),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('التخصص')
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

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMajors::route('/'),
            'create' => Pages\CreateMajor::route('/create'),
            'edit'   => Pages\EditMajor::route('/{record}/edit'),
        ];
    }
}