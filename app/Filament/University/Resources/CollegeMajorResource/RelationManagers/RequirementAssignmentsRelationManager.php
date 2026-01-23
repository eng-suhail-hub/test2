<?php

namespace App\Filament\University\Resources\CollegeMajorResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;
use App\Models\RequirementRule;
class RequirementAssignmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'requirementAssignments';
    protected static ?string $title = 'شروط القبول';

    /**
     * 🔹 الفورم
     */
    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([

            // 1️⃣ اختيار قاعدة الشرط
            Forms\Components\Select::make('requirement_rule_id')
                ->label('قاعدة الشرط')
             /**   ->relationship(
                    name: 'rule',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn ($q) => $q->where('is_active', true)
                )**/
                ->options(
                            RequirementRule::where('is_active', true)
                                ->pluck('name', 'id')
                        )
                ->searchable()
                ->required(),

            // 2️⃣ القيمة المطلوبة
            Forms\Components\Textarea::make('expected_value')
                ->label('القيمة المطلوبة')
                ->helperText('القيمة التي سيتم التحقق منها (مثال: 80، علمي، صنعاء)')
                ->required(),

            // 3️⃣ إجباري أم لا
            Forms\Components\Toggle::make('is_required')
                ->label('شرط إجباري')
                ->default(true),

            // 4️⃣ الأولوية
            Forms\Components\TextInput::make('priority')
                ->label('الأولوية')
                ->numeric()
                ->default(0),

        ]);
    }

    /**
     * 🔹 الجدول
     */
    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('rule.name')
                    ->label('الشرط'),

                Tables\Columns\TextColumn::make('expected_value')
                    ->label('القيمة المطلوبة'),

                Tables\Columns\IconColumn::make('is_required')
                    ->label('إجباري')
                    ->boolean(),

                Tables\Columns\TextColumn::make('priority')
                    ->label('الأولوية'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->mutateFormDataUsing(function (array $data): array {
            $collegeMajor = $this->getOwnerRecord();

            // هنا نضمن كتابة الـ Polymorphic Data بشكل صحيح
            $data['context_type'] = $this->getOwnerRecord()->getMorphClass();
            $data['context_id'] = $this->getOwnerRecord()->id;
            $data['study_type_id'] = $collegeMajor->study_type_id;
            $data['is_active']    = true;

            return $data;
        }),
          ])
        ->actions([
    Tables\Actions\EditAction::make()
        // إذا كنت تحتاج لتحديث هذه القيم أيضاً عند التعديل
        ->mutateFormDataUsing(function (array $data): array {
            $collegeMajor = $this->getOwnerRecord();
            // هنا نضمن كتابة الـ Polymorphic Data بشكل صحيح
            $data['context_type'] = $this->getOwnerRecord()->getMorphClass();
            $data['context_id'] = $this->getOwnerRecord()->id;
            $data['study_type_id'] = $collegeMajor->study_type_id;
            return $data;
        }),
        Tables\Actions\DeleteAction::make(),
            ]);
            }

}