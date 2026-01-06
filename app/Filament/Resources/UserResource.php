<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Hash;

use App\UserRole;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'المستخدمون';
    protected static ?string $pluralModelLabel = 'المستخدمون';

    // 🔐 فقط Super Admin
    public static function canViewAny(): bool
    {
        return auth()->user()?->isSuperAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('بيانات المستخدم')
                ->schema([
                    TextInput::make('name')
                        ->label('الاسم')
                        ->required(),

                    TextInput::make('email')
                        ->label('البريد الإلكتروني')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true),

                    TextInput::make('password')
                        ->label('كلمة المرور')
                        ->password()
                        ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                        ->required(fn (string $context) => $context === 'create')
                        ->dehydrated(fn ($state) => filled($state)),

                    Select::make('role')
                        ->label('الدور')
                        ->options([
                            UserRole::SUPER_ADMIN->value => 'مدير النظام',
                            UserRole::UNIVERSITY_ADMIN->value => 'مدير جامعة',
                            UserRole::STUDENT->value => 'طالب',
                        ])
                        ->required()
                        ->reactive(),
                ])
                ->columns(2),

            // 🏫 ربط الجامعات (فقط لمدير الجامعة)
            Section::make('الجامعات المرتبطة')
                ->schema([
                    CheckboxList::make('universities')
                        ->label('الجامعات')
                        ->relationship('universities', 'name')
                        ->columns(2),
                ])
                ->visible(fn (Forms\Get $get) =>
                    $get('role') === UserRole::UNIVERSITY_ADMIN->value
                ),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),

                TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable(),

                TextColumn::make('role')
                    ->label('الدور')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        UserRole::SUPER_ADMIN->value => 'مدير النظام',
                        UserRole::UNIVERSITY_ADMIN->value => 'مدير جامعة',
                        UserRole::STUDENT->value => 'طالب',
                        default => $state,
                    }),

                TextColumn::make('universities.name')
                    ->label('الجامعات')
                    ->listWithLineBreaks()
                    ->visible(fn ($record) => 
                    $record?->role === UserRole::UNIVERSITY_ADMIN
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => ! $record->isSuperAdmin()),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
