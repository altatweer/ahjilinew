<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Colors\Color;
use Filament\Notifications\Notification;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationLabel = 'المنشورات';
    
    protected static ?string $modelLabel = 'منشور';
    
    protected static ?string $pluralModelLabel = 'المنشورات';
    
    protected static ?string $navigationGroup = 'إدارة المحتوى';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('تفاصيل المنشور')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('المستخدم')
                            ->relationship('user', 'display_name')
                            ->searchable()
                            ->nullable()
                            ->helperText('اتركه فارغاً للمنشورات المجهولة')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('username')
                                    ->label('اسم المستخدم')
                                    ->required(),
                                Forms\Components\TextInput::make('display_name')
                                    ->label('الاسم المعروض')
                                    ->required(),
                                Forms\Components\TextInput::make('email')
                                    ->label('البريد الإلكتروني')
                                    ->email()
                                    ->required(),
                            ])
                            ->preload(),
                            
                        Forms\Components\Textarea::make('content')
                            ->label('محتوى المنشور')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                            
                        Forms\Components\FileUpload::make('image_url')
                            ->label('صورة المنشور')
                            ->image()
                            ->directory('posts')
                            ->nullable(),
                            
                        Forms\Components\Select::make('type')
                            ->label('نوع المنشور')
                            ->options([
                                'anonymous' => 'مجهول',
                                'community' => 'مجتمع'
                            ])
                            ->required()
                            ->default('anonymous'),
                            
                        Forms\Components\Select::make('status')
                            ->label('حالة الموافقة')
                            ->options([
                                'pending' => 'في انتظار الموافقة',
                                'approved' => 'مقبول',
                                'rejected' => 'مرفوض'
                            ])
                            ->required()
                            ->default('approved'),
                            
                        Forms\Components\Toggle::make('is_active')
                            ->label('مفعل')
                            ->default(true)
                            ->helperText('إلغاء التفعيل يخفي المنشور دون حذفه'),
                    ])->columns(2),
                    
                Forms\Components\Section::make('معلومات إضافية')
                    ->schema([
                        Forms\Components\TextInput::make('hashtags')
                            ->label('الهاشتاجات')
                            ->helperText('افصل بينها بفاصلات'),
                            
                        Forms\Components\Select::make('location')
                            ->label('المحافظة')
                            ->options([
                                'baghdad' => 'بغداد',
                                'basra' => 'البصرة',
                                'erbil' => 'أربيل',
                                'mosul' => 'الموصل',
                                'najaf' => 'النجف',
                                'karbala' => 'كربلاء',
                                'sulaymaniyah' => 'السليمانية',
                                'kirkuk' => 'كركوك',
                                'diyala' => 'ديالى',
                                'anbar' => 'الأنبار',
                                'dhi_qar' => 'ذي قار',
                                'babylon' => 'بابل',
                                'wasit' => 'واسط',
                                'saladin' => 'صلاح الدين',
                                'qadisiyyah' => 'القادسية',
                                'maysan' => 'ميسان',
                                'muthanna' => 'المثنى',
                                'dohuk' => 'دهوك'
                            ]),
                            
                        Forms\Components\Toggle::make('is_featured')
                            ->label('منشور مميز')
                            ->helperText('يظهر في المنشورات المميزة')
                            ->default(function ($record) {
                                return $record ? !is_null($record->featured_at) : false;
                            })
                            ->afterStateUpdated(function ($state, $set) {
                                if ($state) {
                                    $set('featured_at', now()->format('Y-m-d H:i:s'));
                                } else {
                                    $set('featured_at', null);
                                }
                            })
                            ->dehydrated(false),
                            
                        Forms\Components\Hidden::make('featured_at'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('content')
                    ->label('المحتوى')
                    ->limit(50)
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('user.display_name')
                    ->label('المستخدم')
                    ->default('مجهول')
                    ->badge()
                    ->color(fn ($record) => $record->user_id ? Color::Blue : Color::Gray),
                    
                Tables\Columns\SelectColumn::make('type')
                    ->label('النوع')
                    ->options([
                        'anonymous' => 'مجهول',
                        'community' => 'مجتمع'
                    ])
                    ->selectablePlaceholder(false),
                    
                Tables\Columns\SelectColumn::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'في انتظار الموافقة',
                        'approved' => 'مقبول',
                        'rejected' => 'مرفوض'
                    ])
                    ->selectablePlaceholder(false),
                    
                Tables\Columns\IconColumn::make('is_active')
                    ->label('مفعل')
                    ->boolean(),
                    
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('مميز')
                    ->boolean()
                    ->getStateUsing(fn ($record) => !is_null($record->featured_at)),
                    
                Tables\Columns\TextColumn::make('location')
                    ->label('المحافظة')
                    ->badge()
                    ->color(Color::Green),
                    
                Tables\Columns\TextColumn::make('likes_count')
                    ->label('الإعجابات')
                    ->sortable()
                    ->numeric(),
                    
                Tables\Columns\TextColumn::make('comments_count')
                    ->label('التعليقات')
                    ->sortable()
                    ->numeric(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ النشر')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('نوع المنشور')
                    ->options([
                        'anonymous' => 'مجهول',
                        'community' => 'مجتمع'
                    ]),
                    
                Tables\Filters\SelectFilter::make('status')
                    ->label('حالة الموافقة')
                    ->options([
                        'pending' => 'في انتظار الموافقة',
                        'approved' => 'مقبول',
                        'rejected' => 'مرفوض'
                    ]),
                    
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('المفعل'),
                    
                Tables\Filters\SelectFilter::make('location')
                    ->label('المحافظة')
                    ->options([
                        'baghdad' => 'بغداد',
                        'basra' => 'البصرة',
                        'erbil' => 'أربيل',
                        'mosul' => 'الموصل',
                        'najaf' => 'النجف',
                        'karbala' => 'كربلاء',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('قبول')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (Post $record) {
                        $record->update(['status' => 'approved']);
                        Notification::make()
                            ->title('تم قبول المنشور بنجاح')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Post $record) => $record->status === 'pending'),
                    
                Tables\Actions\Action::make('reject')
                    ->label('رفض')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->action(function (Post $record) {
                        $record->update(['status' => 'rejected']);
                        Notification::make()
                            ->title('تم رفض المنشور')
                            ->warning()
                            ->send();
                    })
                    ->visible(fn (Post $record) => $record->status === 'pending'),
                    
                Tables\Actions\Action::make('toggle_active')
                    ->label(fn (Post $record) => $record->is_active ? 'إخفاء' : 'إظهار')
                    ->icon(fn (Post $record) => $record->is_active ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->color(fn (Post $record) => $record->is_active ? 'warning' : 'success')
                    ->action(function (Post $record) {
                        $record->update(['is_active' => !$record->is_active]);
                        Notification::make()
                            ->title($record->is_active ? 'تم إظهار المنشور' : 'تم إخفاء المنشور')
                            ->success()
                            ->send();
                    }),
                    
                Tables\Actions\ViewAction::make()
                    ->label('عرض'),
                    
                Tables\Actions\EditAction::make()
                    ->label('تعديل'),
                    
                Tables\Actions\DeleteAction::make()
                    ->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve_selected')
                        ->label('قبول المحدد')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each->update(['status' => 'approved']);
                            Notification::make()
                                ->title('تم قبول المنشورات المحددة')
                                ->success()
                                ->send();
                        }),
                        
                    Tables\Actions\BulkAction::make('hide_selected')
                        ->label('إخفاء المحدد')
                        ->icon('heroicon-o-eye-slash')
                        ->color('warning')
                        ->action(function ($records) {
                            $records->each->update(['is_active' => false]);
                            Notification::make()
                                ->title('تم إخفاء المنشورات المحددة')
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }
    
    public static function getNavigationBadgeColor(): ?string
    {
        return static::getNavigationBadge() > 0 ? 'warning' : 'primary';
    }
}
