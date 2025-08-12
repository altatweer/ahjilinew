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
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationLabel = 'المستخدمين';
    
    protected static ?string $modelLabel = 'مستخدم';
    
    protected static ?string $pluralModelLabel = 'المستخدمين';
    
    protected static ?string $navigationGroup = 'إدارة المستخدمين';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('المعلومات الأساسية')
                    ->schema([
                        Forms\Components\TextInput::make('username')
                            ->label('اسم المستخدم')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('display_name')
                            ->label('الاسم المعروض')
                            ->required()
                            ->maxLength(100)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpan(2),
                    ])->columns(2),
                    
                Forms\Components\Section::make('كلمة المرور')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label('كلمة المرور')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->helperText('اتركها فارغة إذا كنت لا تريد تغييرها'),
                    ]),
                    
                Forms\Components\Section::make('الدور والصلاحيات')
                    ->schema([
                        Forms\Components\Select::make('role')
                            ->label('الدور')
                            ->options([
                                'user' => 'مستخدم عادي',
                                'moderator' => 'مشرف',
                                'admin' => 'مدير',
                                'super-admin' => 'مدير عام',
                            ])
                            ->default('user')
                            ->required()
                            ->columnSpan(1),
                        Forms\Components\Select::make('account_type')
                            ->label('نوع الحساب')
                            ->options([
                                'regular' => 'عادي',
                                'verified' => 'موثق',
                                'counselor' => 'مستشار',
                            ])
                            ->default('regular')
                            ->required()
                            ->columnSpan(1),
                    ])->columns(2),
                    
                Forms\Components\Section::make('الحالة والخصوصية')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true)
                            ->columnSpan(1),
                        Forms\Components\Toggle::make('is_private')
                            ->label('حساب خاص')
                            ->default(false)
                            ->columnSpan(1),
                    ])->columns(2),
                    
                Forms\Components\Section::make('معلومات إضافية')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('رقم الهاتف')
                            ->tel()
                            ->maxLength(20)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('location')
                            ->label('الموقع')
                            ->maxLength(100)
                            ->columnSpan(1),
                        Forms\Components\Textarea::make('bio')
                            ->label('النبذة الشخصية')
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ])->columns(2)->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('username')
                    ->label('اسم المستخدم')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('display_name')
                    ->label('الاسم المعروض')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('role')
                    ->label('الدور')
                    ->colors([
                        'secondary' => 'user',
                        'warning' => 'moderator',
                        'success' => 'admin',
                        'danger' => 'super-admin',
                    ])
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'user' => 'مستخدم عادي',
                        'moderator' => 'مشرف',
                        'admin' => 'مدير',
                        'super-admin' => 'مدير عام',
                        default => $state,
                    }),
                Tables\Columns\BadgeColumn::make('account_type')
                    ->label('نوع الحساب')
                    ->colors([
                        'secondary' => 'regular',
                        'success' => 'verified',
                        'warning' => 'counselor',
                    ])
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'regular' => 'عادي',
                        'verified' => 'موثق',
                        'counselor' => 'مستشار',
                        default => $state,
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\IconColumn::make('is_private')
                    ->label('خاص')
                    ->boolean()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('الهاتف')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('location')
                    ->label('الموقع')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('last_active_at')
                    ->label('آخر نشاط')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->since()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ التسجيل')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('الدور')
                    ->options([
                        'user' => 'مستخدم عادي',
                        'moderator' => 'مشرف', 
                        'admin' => 'مدير',
                        'super-admin' => 'مدير عام',
                    ]),
                Tables\Filters\SelectFilter::make('account_type')
                    ->label('نوع الحساب')
                    ->options([
                        'regular' => 'عادي',
                        'verified' => 'موثق',
                        'counselor' => 'مستشار',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('الحالة')
                    ->trueLabel('نشط')
                    ->falseLabel('غير نشط')
                    ->placeholder('الكل'),
                Tables\Filters\TernaryFilter::make('is_private')
                    ->label('الخصوصية')
                    ->trueLabel('خاص')
                    ->falseLabel('عام')
                    ->placeholder('الكل'),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('من تاريخ'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('إلى تاريخ'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('عرض'),
                Tables\Actions\EditAction::make()->label('تحرير'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف المحدد'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
