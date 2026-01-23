<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdmissionCycleResource\Pages;
use App\Filament\Resources\AdmissionCycleResource\RelationManagers;
use App\Models\ {
  AdmissionCycle,
  College,
  CollegeMajor,
  Major,
  StudyType,
  University
};

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MorphToSelect;

class AdmissionCycleResource extends Resource
{
    protected static ?string $model = AdmissionCycle::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'التسجيل والقبول';
    protected static ?string $pluralModelLabel = 'التسجيل والقبول';
    protected static ?string  $modelLabel = 'فتح فترة تسجيل وقبول';
    protected static ?string $navigationGroup = 'إدارة الجامعة';


    public static function form(Form $form): Form
    {
        // Get the current user's university ID to keep everything scoped
    $universityId = 1;
        return $form
            ->schema([
              Forms\Components\TextInput::make('name')
                        ->label('الاسم /العنوان')
                        ->required(),
                Forms\Components\Textarea::make('description')
                        ->label('الوصف')
                        ->columnSpanFull(),
                        
                MorphToSelect::make('applicable')
                ->label('الجهة المستهدفة')
                ->types([
                    // 1. University Scope
                    MorphToSelect\Type::make(University::class)
                        ->label('جامعة')
                        ->titleAttribute('name')
                        ->modifyOptionsQueryUsing(fn (Builder $query) => 
                            $query->where('id', $universityId)
                        ),

                    // 2. College Scope (Only colleges in this university)
                    MorphToSelect\Type::make(College::class)
                        ->label('كلية')
                        ->titleAttribute('name')
                        ->modifyOptionsQueryUsing(fn (Builder $query) => 
                            $query->where('university_id', $universityId)
                        ),

                    // 3. CollegeMajor Scope (Scoped to the university)
                    MorphToSelect\Type::make(CollegeMajor::class)
                        ->label('تخصص الكلية')
                        // If CollegeMajor doesn't have a 'name' column directly, 
                        // we use the relationship to the Major model
                        ->getOptionLabelFromRecordUsing(fn (CollegeMajor $record) => 
                            "{$record->college->name} - {$record->major->name}"
                        )
                        ->modifyOptionsQueryUsing(fn (Builder $query) => 
                            $query->whereHas('college', function ($q) use ($universityId) {
                                $q->where('university_id', $universityId);
                            })
                        ),
                ])
                ->searchable()
                ->preload()
                ->required(),

                    Forms\Components\Select::make('study_type_id')
                        ->label('نوع الدراسة')
                        ->options(
                            StudyType::where('is_active', true)->pluck('name', 'id')
                        )
                        ->required(),

                      Grid::make(2) // Creates two columns
    ->schema([
        DateTimePicker::make('starts_at')
            ->label('تاريخ البدء')
            ->native(false)
            ->prefix('من')
            ->seconds(false)
            ->required(),
            
        DateTimePicker::make('ends_at')
            ->label('تاريخ الانتهاء')
            ->native(false)
            ->prefix('إلى')
            ->seconds(false)
            ->after('starts_at')
            ->required(),
    ]),
    Forms\Components\TextInput::make('capacity')
                        ->label('عدد المقاعد')
                        ->numeric()
                        ->required(),

                    Forms\Components\Toggle::make('is_active')
                        ->label('مفعل')
                        ->default(true),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('university.name')
                    ->label('الجامعة'),
                Tables\Columns\TextColumn::make('major.name')
                    ->label('التخصص'),

                Tables\Columns\TextColumn::make('college.name')
                    ->label('الكلية'),

                Tables\Columns\TextColumn::make('studyType.name')
                    ->label('نوع الدراسة'),

                Tables\Columns\TextColumn::make('capacity')
                    ->label('المقاعد'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('مفعل')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmissionCycles::route('/'),
            'create' => Pages\CreateAdmissionCycle::route('/create'),
            'edit' => Pages\EditAdmissionCycle::route('/{record}/edit'),
        ];
    }
}
