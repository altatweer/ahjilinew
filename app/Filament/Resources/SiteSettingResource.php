<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Filament\Resources\SiteSettingResource\RelationManagers;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Colors\Color;
use Filament\Notifications\Notification;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    
    protected static ?string $navigationLabel = 'إعدادات الموقع';
    
    protected static ?string $modelLabel = 'إعداد';
    
    protected static ?string $pluralModelLabel = 'إعدادات الموقع';
    
    protected static ?string $navigationGroup = 'الإعدادات';
    
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('تفاصيل الإعداد')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->label('مفتاح الإعداد')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->disabled(fn ($record) => $record !== null)
                            ->helperText('لا يمكن تغيير المفتاح بعد الإنشاء'),
                            
                        Forms\Components\Textarea::make('description')
                            ->label('وصف الإعداد')
                            ->rows(2)
                            ->columnSpanFull(),
                            
                        Forms\Components\Select::make('type')
                            ->label('نوع البيانات')
                            ->options([
                                'text' => 'نص',
                                'boolean' => 'صحيح/خطأ',
                                'number' => 'رقم',
                                'email' => 'بريد إلكتروني',
                                'url' => 'رابط',
                                'json' => 'JSON'
                            ])
                            ->required()
                            ->live(),
                            
                        Forms\Components\Group::make()
                            ->schema([
                                // للنص العادي
                                Forms\Components\TextInput::make('value')
                                    ->label('القيمة')
                                    ->visible(fn (Forms\Get $get) => in_array($get('type'), ['text', 'url']))
                                    ->required(),
                                    
                                // للأرقام
                                Forms\Components\TextInput::make('value')
                                    ->label('القيمة')
                                    ->numeric()
                                    ->visible(fn (Forms\Get $get) => $get('type') === 'number')
                                    ->required(),
                                    
                                // للبريد الإلكتروني
                                Forms\Components\TextInput::make('value')
                                    ->label('القيمة')
                                    ->email()
                                    ->visible(fn (Forms\Get $get) => $get('type') === 'email')
                                    ->required(),
                                    
                                // للقيم المنطقية
                                Forms\Components\Select::make('value')
                                    ->label('القيمة')
                                    ->options([
                                        'true' => 'مفعل',
                                        'false' => 'غير مفعل'
                                    ])
                                    ->visible(fn (Forms\Get $get) => $get('type') === 'boolean')
                                    ->required(),
                                    
                                // لـ JSON
                                Forms\Components\Textarea::make('value')
                                    ->label('القيمة (JSON)')
                                    ->rows(4)
                                    ->visible(fn (Forms\Get $get) => $get('type') === 'json')
                                    ->required(),
                            ]),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('المفتاح')
                    ->searchable()
                    ->weight('bold')
                    ->color(Color::Blue),
                    
                Tables\Columns\TextColumn::make('description')
                    ->label('الوصف')
                    ->limit(50),
                    
                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'boolean' => 'success',
                        'number' => 'info',
                        'email' => 'warning',
                        'url' => 'danger',
                        'json' => 'gray',
                        default => 'primary',
                    }),
                    
                Tables\Columns\TextColumn::make('value')
                    ->label('القيمة الحالية')
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->type === 'boolean') {
                            return $state === 'true' ? '✅ مفعل' : '❌ غير مفعل';
                        }
                        
                        if ($record->type === 'json') {
                            return '📄 ' . str($state)->limit(30);
                        }
                        
                        return $state;
                    })
                    ->color(fn ($record) => $record->type === 'boolean' && $record->value === 'true' ? Color::Green : Color::Gray),
                    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخر تحديث')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('نوع البيانات')
                    ->options([
                        'text' => 'نص',
                        'boolean' => 'صحيح/خطأ',
                        'number' => 'رقم',
                        'email' => 'بريد إلكتروني',
                        'url' => 'رابط',
                        'json' => 'JSON'
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('toggle')
                    ->label(fn ($record) => $record->value === 'true' ? 'إيقاف' : 'تفعيل')
                    ->icon(fn ($record) => $record->value === 'true' ? 'heroicon-o-pause' : 'heroicon-o-play')
                    ->color(fn ($record) => $record->value === 'true' ? 'warning' : 'success')
                    ->visible(fn ($record) => $record->type === 'boolean')
                    ->action(function ($record) {
                        $newValue = $record->value === 'true' ? 'false' : 'true';
                        $record->update(['value' => $newValue]);
                        
                        Notification::make()
                            ->title('تم تحديث الإعداد: ' . $record->description)
                            ->body('القيمة الجديدة: ' . ($newValue === 'true' ? 'مفعل' : 'غير مفعل'))
                            ->success()
                            ->send();
                    }),
                    
                Tables\Actions\EditAction::make()
                    ->label('تعديل'),
            ])
            ->bulkActions([
                // لا نسمح بالحذف الجماعي للإعدادات المهمة
            ])
            ->defaultSort('key')
            ->striped();
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
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
    
    public static function canCreate(): bool
    {
        return true; // يمكن إضافة إعدادات جديدة
    }
    
    public static function canDelete($record): bool
    {
        // منع حذف الإعدادات الأساسية
        $protectedKeys = [
            'require_registration',
            'auto_approve_posts',
            'auto_approve_comments',
            'admin_email'
        ];
        
        return !in_array($record->key, $protectedKeys);
    }
}
