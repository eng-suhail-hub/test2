<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequirementRuleResource\Pages;
use App\Models\RequirementRule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RequirementRuleResource extends Resource
{
    protected static ?string $model = RequirementRule::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'قواعد الشروط';
    protected static ?string $pluralModelLabel = 'قواعد الشروط';
    protected static ?string $navigationGroup = 'محرك القبول';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('تعريف القاعدة')
                ->schema([
                    Forms\Components\TextInput::make('code')
                        ->label('الكود')
                        ->required()
                        ->unique(ignoreRecord: true),

                    Forms\Components\TextInput::make('name')
                        ->label('اسم القاعدة')
                        ->required(),

                    Forms\Components\Textarea::make('description')
                        ->label('الوصف')
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Forms\Components\Section::make('نطاق التطبيق')
                ->schema([
                    Forms\Components\Select::make('target_type')
                        ->label('الكيان المستهدف')
                        ->options([
                            'Student' => 'الطالب',
                            'Application' => 'طلب التقديم',
                            'SecondaryEducation' => 'الثانوية',
                        ])
                        ->required(),

                    Forms\Components\TextInput::make('target_field')
                        ->label('الحقل المستهدف')
                        ->helperText('مثال: gpa, age, track, governorate_id')
                        ->required(),
                ])
                ->columns(2),

            Forms\Components\Section::make('طريقة التحقق')
                ->schema([
                    Forms\Components\Select::make('operator')
                        ->label('المعامل')
                        ->options([
                            '>=' => 'أكبر أو يساوي',
                            '<=' => 'أقل أو يساوي',
                            '='  => 'يساوي',
                            '!=' => 'لا يساوي',
                            'IN' => 'ضمن قائمة',
                            'NOT_IN' => 'ليس ضمن قائمة',
                            'BETWEEN' => 'بين قيمتين',
                        ])
                        ->required(),

                    Forms\Components\Select::make('value_type')
                        ->label('نوع القيمة')
                        ->options([
                            'number' => 'رقم',
                            'string' => 'نص',
                            'array'  => 'قائمة',
                            'range'  => 'مدى',
                        ])
                        ->required(),
                ])
                ->columns(2),

            Forms\Components\Section::make('إعدادات')
                ->schema([
                    Forms\Components\Toggle::make('is_global')
                        ->label('قاعدة عامة على النظام'),

                    Forms\Components\Toggle::make('is_active')
                        ->label('مفعلة')
                        ->default(true),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->label('الكود')->searchable(),
                Tables\Columns\TextColumn::make('name')->label('الاسم')->searchable(),
                Tables\Columns\TextColumn::make('target_type')->label('الكيان'),
                Tables\Columns\TextColumn::make('target_field')->label('الحقل'),
                Tables\Columns\TextColumn::make('operator')->label('المعامل'),
                Tables\Columns\IconColumn::make('is_active')->label('مفعل')->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListRequirementRules::route('/'),
            'create' => Pages\CreateRequirementRule::route('/create'),
            'edit'   => Pages\EditRequirementRule::route('/{record}/edit'),
        ];
    }
}