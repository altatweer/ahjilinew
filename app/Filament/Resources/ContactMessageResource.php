<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Filament\Resources\ContactMessageResource\RelationManagers;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Colors\Color;
use Filament\Notifications\Notification;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    
    protected static ?string $navigationLabel = 'رسائل الموقع';
    
    protected static ?string $modelLabel = 'رسالة';
    
    protected static ?string $pluralModelLabel = 'رسائل الموقع';
    
    protected static ?string $navigationGroup = 'إدارة المستخدمين';
    
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('تفاصيل الرسالة')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('اسم المرسل')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->nullable(),
                            
                        Forms\Components\TextInput::make('phone')
                            ->label('رقم الهاتف')
                            ->nullable(),
                            
                        Forms\Components\TextInput::make('subject')
                            ->label('موضوع الرسالة')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\Select::make('type')
                            ->label('نوع الرسالة')
                            ->options([
                                'complaint' => 'شكوى',
                                'suggestion' => 'اقتراح',
                                'support' => 'دعم تقني',
                                'other' => 'أخرى'
                            ])
                            ->required(),
                            
                        Forms\Components\Select::make('status')
                            ->label('حالة الرسالة')
                            ->options([
                                'unread' => 'غير مقروءة',
                                'read' => 'مقروءة',
                                'replied' => 'تم الرد',
                                'archived' => 'مؤرشفة'
                            ])
                            ->required(),
                    ])->columns(2),
                    
                Forms\Components\Section::make('محتوى الرسالة')
                    ->schema([
                        Forms\Components\Textarea::make('message')
                            ->label('نص الرسالة')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
                    
                Forms\Components\Section::make('رد الإدارة')
                    ->schema([
                        Forms\Components\Textarea::make('admin_reply')
                            ->label('رد المدير')
                            ->rows(4)
                            ->columnSpanFull()
                            ->placeholder('اكتب ردك هنا...'),
                            
                        Forms\Components\DateTimePicker::make('replied_at')
                            ->label('تاريخ الرد')
                            ->nullable(),
                    ]),
                    
                Forms\Components\Section::make('معلومات إضافية')
                    ->schema([
                        Forms\Components\TextInput::make('ip_address')
                            ->label('عنوان IP')
                            ->disabled(),
                            
                        Forms\Components\Placeholder::make('created_at')
                            ->label('تاريخ الإرسال')
                            ->content(fn (?ContactMessage $record): string => $record ? $record->created_at->format('d/m/Y H:i') : 'غير محدد'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('المرسل')
                    ->searchable()
                    ->weight('bold'),
                    
                Tables\Columns\TextColumn::make('subject')
                    ->label('الموضوع')
                    ->searchable()
                    ->limit(40),
                    
                Tables\Columns\TextColumn::make('email')
                    ->label('البريد')
                    ->searchable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('phone')
                    ->label('الهاتف')
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'complaint' => 'danger',
                        'suggestion' => 'success',
                        'support' => 'warning',
                        'other' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'complaint' => 'شكوى',
                        'suggestion' => 'اقتراح',
                        'support' => 'دعم تقني',
                        'other' => 'أخرى',
                        default => $state,
                    }),
                    
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'unread' => 'danger',
                        'read' => 'warning',
                        'replied' => 'success',
                        'archived' => 'gray',
                        default => 'info',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'unread' => 'غير مقروءة',
                        'read' => 'مقروءة',
                        'replied' => 'تم الرد',
                        'archived' => 'مؤرشفة',
                        default => $state,
                    }),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإرسال')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('admin_reply')
                    ->label('رد المدير')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('حالة الرسالة')
                    ->options([
                        'unread' => 'غير مقروءة',
                        'read' => 'مقروءة',
                        'replied' => 'تم الرد',
                        'archived' => 'مؤرشفة'
                    ]),
                    
                Tables\Filters\SelectFilter::make('type')
                    ->label('نوع الرسالة')
                    ->options([
                        'complaint' => 'شكوى',
                        'suggestion' => 'اقتراح',
                        'support' => 'دعم تقني',
                        'other' => 'أخرى'
                    ]),
                    
                Tables\Filters\Filter::make('has_reply')
                    ->label('تم الرد عليها')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('admin_reply')),
                    
                Tables\Filters\Filter::make('no_reply')
                    ->label('لم يتم الرد')
                    ->query(fn (Builder $query): Builder => $query->whereNull('admin_reply')),
            ])
            ->actions([
                Tables\Actions\Action::make('mark_read')
                    ->label('تمييز كمقروءة')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->action(function (ContactMessage $record) {
                        $record->update(['status' => 'read']);
                        Notification::make()
                            ->title('تم تمييز الرسالة كمقروءة')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (ContactMessage $record) => $record->status === 'unread'),
                    
                Tables\Actions\Action::make('quick_reply')
                    ->label('رد سريع')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->form([
                        Forms\Components\Textarea::make('reply')
                            ->label('نص الرد')
                            ->required()
                            ->rows(4),
                    ])
                    ->action(function (ContactMessage $record, array $data) {
                        $record->update([
                            'admin_reply' => $data['reply'],
                            'status' => 'replied',
                            'replied_at' => now()
                        ]);
                        
                        // هنا يمكن إرسال بريد إلكتروني للمرسل
                        // Mail::to($record->email)->send(new ReplyMail($record));
                        
                        Notification::make()
                            ->title('تم إرسال الرد بنجاح')
                            ->success()
                            ->send();
                    }),
                    
                Tables\Actions\Action::make('archive')
                    ->label('أرشفة')
                    ->icon('heroicon-o-archive-box')
                    ->color('gray')
                    ->action(function (ContactMessage $record) {
                        $record->update(['status' => 'archived']);
                        Notification::make()
                            ->title('تم أرشفة الرسالة')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (ContactMessage $record) => $record->status !== 'archived'),
                    
                Tables\Actions\ViewAction::make()
                    ->label('عرض'),
                    
                Tables\Actions\EditAction::make()
                    ->label('تعديل'),
                    
                Tables\Actions\DeleteAction::make()
                    ->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('mark_all_read')
                        ->label('تمييز الكل كمقروء')
                        ->icon('heroicon-o-eye')
                        ->color('info')
                        ->action(function ($records) {
                            $records->each->update(['status' => 'read']);
                            Notification::make()
                                ->title('تم تمييز جميع الرسائل المحددة كمقروءة')
                                ->success()
                                ->send();
                        }),
                        
                    Tables\Actions\BulkAction::make('archive_all')
                        ->label('أرشفة الكل')
                        ->icon('heroicon-o-archive-box')
                        ->color('gray')
                        ->action(function ($records) {
                            $records->each->update(['status' => 'archived']);
                            Notification::make()
                                ->title('تم أرشفة جميع الرسائل المحددة')
                                ->success()
                                ->send();
                        }),
                        
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('حذف المحدد'),
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
            'index' => Pages\ListContactMessages::route('/'),
            'create' => Pages\CreateContactMessage::route('/create'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'unread')->count();
    }
    
    public static function getNavigationBadgeColor(): ?string
    {
        return static::getNavigationBadge() > 0 ? 'danger' : 'primary';
    }
    
    public static function canCreate(): bool
    {
        return false; // الرسائل تأتي من النموذج العام فقط
    }
}
