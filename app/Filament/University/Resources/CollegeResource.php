<?php

namespace App\Filament\University\Resources;

use App\Filament\University\Resources\CollegeResource\Pages;
use App\Models\College;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CollegeResource extends Resource
{
    protected static ?string $model = College::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationLabel = 'الكليات';
    protected static ?string $modelLabel = 'كلية';
    protected static ?string $pluralModelLabel = 'الكليات';

    protected static ?string $navigationGroup = 'إدارة الجامعة';

    /**
     * 🔒 تقييد العرض على جامعة المستخدم
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('university_id', auth()->user()->university()->id);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('اسم الكلية')
                ->required()
                ->maxLength(255),

            
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('اسم الكلية')
                    ->searchable(),

                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListColleges::route('/'),
            'create' => Pages\CreateCollege::route('/create'),
            'edit' => Pages\EditCollege::route('/{record}/edit'),
        ];
    }
}