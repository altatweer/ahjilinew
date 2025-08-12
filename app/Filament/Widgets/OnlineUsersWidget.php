<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class OnlineUsersWidget extends BaseWidget
{
    protected static ?string $heading = 'المستخدمين المتواجدين الآن';
    
    protected static ?int $sort = 3;
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->where('last_seen_at', '>=', now()->subMinutes(5))
                    ->orderBy('last_seen_at', 'desc')
            )
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label('الصورة')
                    ->circular()
                    ->defaultImageUrl(function () {
                        return 'https://ui-avatars.com/api/?name=مستخدم&background=0ea5e9&color=fff';
                    }),
                    
                Tables\Columns\TextColumn::make('display_name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('username')
                    ->label('اسم المستخدم')
                    ->searchable()
                    ->prefix('@'),
                    
                Tables\Columns\TextColumn::make('role')
                    ->label('الدور')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'user' => 'gray',
                        'moderator' => 'success', 
                        'admin' => 'warning',
                        'super-admin' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'user' => 'مستخدم',
                        'moderator' => 'مشرف',
                        'admin' => 'إداري',
                        'super-admin' => 'مدير عام',
                        default => $state,
                    }),
                    
                Tables\Columns\TextColumn::make('last_seen_at')
                    ->label('آخر ظهور')
                    ->dateTime('H:i')
                    ->sortable()
                    ->since(),
                    
                Tables\Columns\TextColumn::make('location')
                    ->label('الموقع')
                    ->limit(20)
                    ->placeholder('غير محدد'),
            ])
            ->defaultSort('last_seen_at', 'desc')
            ->paginated([5, 10, 25])
            ->poll('30s') // تحديث كل 30 ثانية
            ->emptyStateHeading('لا يوجد مستخدمين متواجدين الآن')
            ->emptyStateDescription('سيظهر المستخدمين المتواجدين خلال آخر 5 دقائق هنا')
            ->emptyStateIcon('heroicon-o-users');
    }
    
    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [5, 10, 25];
    }
}