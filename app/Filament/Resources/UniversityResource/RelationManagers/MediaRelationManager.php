<?php

namespace App\Filament\Resources\UniversityResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class MediaRelationManager extends RelationManager
{
    protected static string $relationship = 'media';

    protected static ?string $title = 'وسائط الجامعة';

    public function form(Form $form): Form
    {
        return $form->schema([
            Select::make('type')
                ->label('نوع الوسائط')
                ->options([
                    'IMAGE' => 'صورة',
                    'VIDEO' => 'فيديو',
                ])
                ->required(),

            FileUpload::make('path')
                ->label('الملف')
                ->required()
                ->directory('universities/media')
                ->preserveFilenames()
                ->visibility('public')
                ->acceptedFileTypes([
                    'image/*',
                    'video/*',
                ]),
                Forms\Components\TextInput::make('order')
                ->label('ترتيب العرض')
                ->numeric()
                ->helperText('رقم أصغر = عرض أول')
                ->default(0),
        ]);
    }

    public function table(Table $table): Table
{
    return $table
        ->reorderable('order')
        ->defaultSort('order')
        ->columns([
            Tables\Columns\TextColumn::make('order')
                ->label('الترتيب'),

            Tables\Columns\ImageColumn::make('path')
                ->label('المعاينة')
                ->height(50),
        ])
        ->headerActions([
            Tables\Actions\CreateAction::make()
                ->label('إضافة وسائط'),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
}
}