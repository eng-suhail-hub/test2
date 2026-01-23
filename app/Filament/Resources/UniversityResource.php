<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UniversityResource\Pages;
use App\Filament\Resources\UniversityResource\RelationManagers;
use App\Models\University;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Toggle;

class UniversityResource extends Resource
{
    protected static ?string $model = University::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'الجامعات';
    protected static ?string $modelLabel = 'الجامعة';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('اسم الجامعة')
                ->required(),

            Select::make('governorate_id')
                ->label('المحافظة')
                ->relationship('governorate', 'name')
                ->required(),
            Forms\Components\Textarea::make('description')
                        ->label('الوصف')
                        ->columnSpanFull(),
            ToggleButtons::make('type')
                ->label('النوع')
                ->options([
                    'GOVERNMENT' => 'حكومي',
                    'PRIVATE' => 'خاص',
                 ])
                ->grouped() // هذه هي الوظيفة التي تجعل الأزرار ملتصقة ببعضها كما في الصورة
                ->default('GOVERNMENT') // اليار الافتراضي
                ->required(),            
            FileUpload::make('logo_path')
                ->label('شعار الجامعة')
                ->image(),

            Toggle::make('is_active')
                ->label('مفعلة')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('الاسم')->searchable(),
                TextColumn::make('governorate.name')->label('المحافظة')
                ,TextColumn::make('type')->label('النوع')->searchable(),
                IconColumn::make('is_active')->label('الحالة')->boolean(),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->filters([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\MediaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUniversities::route('/'),
            'create' => Pages\CreateUniversity::route('/create'),
            'edit' => Pages\EditUniversity::route('/{record}/edit'),
        ];
    }
}
