<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequirementAssignmentResource\Pages;
use App\Models\{
    RequirementAssignment,
    RequirementRule,
    StudyType,
    University,
    College,
    Major
};
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RequirementAssignmentResource extends Resource
{
    protected static ?string $model = RequirementAssignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';
    protected static ?string $navigationLabel = 'تعيين الشروط';
    protected static ?string $pluralModelLabel = 'تعيين الشروط';
    protected static ?string $navigationGroup = 'محرك القبول';

    /**
     * 🔐 RBAC + Multi-Tenant Query
     */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = auth()->user();

        if ($user->isUniversityAdmin()) {
            $universityId = $user->university()->id;

            $query->where(function ($q) use ($universityId) {
                $q->where('context_type', 'SYSTEM')
                  ->orWhere(function ($q) use ($universityId) {
                      $q->where('context_type', 'UNIVERSITY')
                        ->where('context_id', $universityId);
                  })
                  ->orWhereIn('context_id', function ($sub) use ($universityId) {
                      $sub->select('id')
                          ->from('colleges')
                          ->where('university_id', $universityId);
                  });
            });
        }

        return $query;
    }

    /**
     * 🧠 Dynamic Form
     */
    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('القاعدة')
                ->schema([
                    Forms\Components\Select::make('requirement_rule_id')
                        ->label('قاعدة الشرط')
                        ->options(
                            RequirementRule::where('is_active', true)
                                ->pluck('name', 'id')
                        )
                        ->searchable()
                        ->required()
                        ->reactive(),
                ]),

            Forms\Components\Section::make('القيمة المطلوبة')
                ->schema([
                    Forms\Components\TextInput::make('expected_value')
                        ->label('القيمة')
                        ->numeric()
                        ->required()
                        ->visible(fn ($get) =>
                            optional(
                                RequirementRule::find($get('requirement_rule_id'))
                            )->value_type === 'number'
                        ),

                    Forms\Components\TextInput::make('expected_value')
                        ->label('القيمة النصية')
                        ->required()
                        ->visible(fn ($get) =>
                            optional(
                                RequirementRule::find($get('requirement_rule_id'))
                            )->value_type === 'string'
                        ),

                    Forms\Components\Textarea::make('expected_value')
                        ->label('القيمة (JSON)')
                        ->helperText('مثال: [85,90] أو {"min":70,"max":95}')
                        ->required()
                        ->visible(fn ($get) =>
                            in_array(
                                optional(
                                    RequirementRule::find($get('requirement_rule_id'))
                                )->value_type,
                                ['array', 'range']
                            )
                        ),
                ]),

            Forms\Components\Section::make('السياق')
                ->schema([
                    Forms\Components\Select::make('context_type')
                        ->label('نطاق التطبيق')
                        ->options([
                            'SYSTEM' => 'النظام',
                            'UNIVERSITY' => 'جامعة',
                            'COLLEGE' => 'كلية',
                            'MAJOR' => 'تخصص',
                        ])
                        ->required()
                        ->reactive(),

                    Forms\Components\Select::make('context_id')
                        ->label('الكيان')
                        ->options(fn ($get) => match ($get('context_type')) {
                            'UNIVERSITY' => University::pluck('name', 'id'),
                            'COLLEGE' => College::pluck('name', 'id'),
                            'MAJOR' => Major::pluck('name', 'id'),
                            default => [],
                        })
                        ->visible(fn ($get) => $get('context_type') !== 'SYSTEM')
                        ->required(fn ($get) => $get('context_type') !== 'SYSTEM'),
                ])
                ->columns(2),

            Forms\Components\Section::make('نوع الدراسة')
                ->schema([
                    Forms\Components\Select::make('study_type_id')
                        ->label('نوع الدراسة')
                        ->options(
                            StudyType::where('is_active', true)
                                ->pluck('name', 'id')
                        )
                        ->searchable()
                        ->nullable()
                        ->helperText('اتركه فارغًا ليطبق على جميع الأنواع'),
                ]),

            Forms\Components\Section::make('إعدادات إضافية')
                ->schema([
                    Forms\Components\Toggle::make('is_required')
                        ->label('إجباري')
                        ->default(true),

                    Forms\Components\TextInput::make('priority')
                        ->label('الأولوية')
                        ->numeric()
                        ->default(0),

                    Forms\Components\Toggle::make('is_active')
                        ->label('مفعل')
                        ->default(true),
                ])
                ->columns(2),
        ]);
    }

    /**
     * 📊 Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rule.name')
                    ->label('القاعدة')
                    ->searchable(),

                Tables\Columns\TextColumn::make('context_type')
                    ->label('السياق'),

                Tables\Columns\TextColumn::make('studyType.name')
                    ->label('نوع الدراسة')
                    ->default('الكل'),

                Tables\Columns\IconColumn::make('is_required')
                    ->label('إجباري')
                    ->boolean(),

                Tables\Columns\TextColumn::make('priority')
                    ->label('الأولوية'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListRequirementAssignments::route('/'),
            'create' => Pages\CreateRequirementAssignment::route('/create'),
            'edit'   => Pages\EditRequirementAssignment::route('/{record}/edit'),
        ];
    }
}