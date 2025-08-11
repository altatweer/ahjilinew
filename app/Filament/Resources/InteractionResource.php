<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InteractionResource\Pages;
use App\Filament\Resources\InteractionResource\RelationManagers;
use App\Models\Interaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Filters\SelectFilter;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InteractionResource extends Resource
{
    protected static ?string $model = Interaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';
    
    protected static ?string $navigationLabel = 'التفاعلات';
    
    protected static ?string $modelLabel = 'تفاعل';
    
    protected static ?string $pluralModelLabel = 'التفاعلات';
    
    protected static ?string $navigationGroup = 'الإحصائيات والتقارير';
    
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'id')
                    ->required(),
                Forms\Components\Select::make('post_id')
                    ->relationship('post', 'id')
                    ->required(),
                Forms\Components\TextInput::make('type')
                    ->required(),
                Forms\Components\TextInput::make('metadata'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.display_name')
                    ->label('المستخدم')
                    ->searchable()
                    ->sortable()
                    ->default('غير محدد'),
                    
                Tables\Columns\TextColumn::make('post.content')
                    ->label('المنشور')
                    ->limit(50)
                    ->searchable(),
                    
                Tables\Columns\BadgeColumn::make('type')
                    ->label('نوع التفاعل')
                    ->colors([
                        'success' => 'like',
                        'primary' => 'share',
                        'warning' => 'save',
                        'danger' => 'report',
                        'info' => 'comment_like',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'like' => 'إعجاب',
                        'share' => 'مشاركة',
                        'save' => 'حفظ',
                        'report' => 'إبلاغ',
                        'comment_like' => 'إعجاب تعليق',
                        default => $state,
                    }),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ التفاعل')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('نوع التفاعل')
                    ->options([
                        'like' => 'إعجاب',
                        'share' => 'مشاركة', 
                        'save' => 'حفظ',
                        'report' => 'إبلاغ',
                        'comment_like' => 'إعجاب تعليق',
                    ]),
                    
                Tables\Filters\Filter::make('created_at')
                    ->label('التاريخ')
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
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('عرض'),
                Tables\Actions\DeleteAction::make()
                    ->label('حذف')
                    ->visible(fn (Interaction $record): bool => $record->type === 'report'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('حذف المحدد'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s');
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
            'index' => Pages\ListInteractions::route('/'),
            'create' => Pages\CreateInteraction::route('/create'),
            'edit' => Pages\EditInteraction::route('/{record}/edit'),
        ];
    }
}
