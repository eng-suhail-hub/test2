<?php

namespace App\Filament\University\Resources;

use App\Filament\University\Resources\CollegeMajorResource\Pages;
use App\Filament\University\Resources\CollegeMajorResource\RelationManagers;
use App\Models\{
    CollegeMajor,
    College,
    Major,
    StudyType
};
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CollegeMajorResource extends Resource
{
    protected static ?string $model = CollegeMajor::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'تخصصات الجامعة';
    protected static ?string $pluralModelLabel = 'تخصصات الجامعة';
    protected static ?string $navigationGroup = 'إدارة الجامعة';

    /**
     * 🔐 Multi-tenant filtering
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('college', function ($q) {
                $q->where('university_id', auth()->user()->university()->id);
            });
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('ربط التخصص')
                ->schema([
                    Forms\Components\Select::make('college_id')
                        ->label('الكلية')
                        ->options(
                            College::where('university_id', auth()->user()->university()->id)
                                ->pluck('name', 'id')
                        )
                        ->required(),

                    Forms\Components\Select::make('major_id')
                        ->label('التخصص')
                        ->options(
                            Major::where('is_active', true)->pluck('name', 'id')
                        )
                        ->searchable()
                        ->required(),

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
                Tables\Columns\TextColumn::make('major.name')
                    ->label('التخصص'),

                Tables\Columns\TextColumn::make('college.name')
                    ->label('الكلية'),

                

                Tables\Columns\IconColumn::make('is_active')
                    ->label('مفعل')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCollegeMajors::route('/'),
            'create' => Pages\CreateCollegeMajor::route('/create'),
            'edit'   => Pages\EditCollegeMajor::route('/{record}/edit'),
        ];
    }
}