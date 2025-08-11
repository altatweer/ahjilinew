<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Filament\Resources\CommentResource\RelationManagers;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Colors\Color;
use Filament\Notifications\Notification;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    
    protected static ?string $navigationLabel = 'التعليقات';
    
    protected static ?string $modelLabel = 'تعليق';
    
    protected static ?string $pluralModelLabel = 'التعليقات';
    
    protected static ?string $navigationGroup = 'إدارة المحتوى';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('تفاصيل التعليق')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('المستخدم')
                            ->relationship('user', 'display_name')
                            ->required(),
                            
                        Forms\Components\Select::make('post_id')
                            ->label('المنشور')
                            ->relationship('post', 'content')
                            ->required()
                            ->searchable(),
                            
                        Forms\Components\Select::make('parent_id')
                            ->label('تعليق أصلي (للردود)')
                            ->relationship('parent', 'content')
                            ->nullable(),
                            
                        Forms\Components\Textarea::make('content')
                            ->label('محتوى التعليق')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                            
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
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('content')
                    ->label('المحتوى')
                    ->limit(50)
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('user.display_name')
                    ->label('المستخدم')
                    ->badge()
                    ->color(Color::Blue),
                    
                Tables\Columns\TextColumn::make('post.content')
                    ->label('المنشور')
                    ->limit(30)
                    ->searchable(),
                    
                Tables\Columns\IconColumn::make('parent_id')
                    ->label('رد؟')
                    ->boolean()
                    ->trueIcon('heroicon-o-arrow-turn-down-right')
                    ->falseIcon('heroicon-o-chat-bubble-left')
                    ->trueColor('info')
                    ->falseColor('primary'),
                    
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
                    
                Tables\Columns\TextColumn::make('likes_count')
                    ->label('الإعجابات')
                    ->numeric()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('حالة الموافقة')
                    ->options([
                        'pending' => 'في انتظار الموافقة',
                        'approved' => 'مقبول',
                        'rejected' => 'مرفوض'
                    ]),
                    
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('المفعل'),
                    
                Tables\Filters\Filter::make('is_reply')
                    ->label('الردود فقط')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('parent_id')),
                    
                Tables\Filters\Filter::make('parent_comments')
                    ->label('التعليقات الأصلية فقط')
                    ->query(fn (Builder $query): Builder => $query->whereNull('parent_id')),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('قبول')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (Comment $record) {
                        $record->update(['status' => 'approved']);
                        Notification::make()
                            ->title('تم قبول التعليق بنجاح')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Comment $record) => $record->status === 'pending'),
                    
                Tables\Actions\Action::make('reject')
                    ->label('رفض')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->action(function (Comment $record) {
                        $record->update(['status' => 'rejected']);
                        Notification::make()
                            ->title('تم رفض التعليق')
                            ->warning()
                            ->send();
                    })
                    ->visible(fn (Comment $record) => $record->status === 'pending'),
                    
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
                                ->title('تم قبول التعليقات المحددة')
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
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
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
