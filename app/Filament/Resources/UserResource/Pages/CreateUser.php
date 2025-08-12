<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'تم إنشاء المستخدم بنجاح';
    }
    
    public function getTitle(): string
    {
        return 'إضافة مستخدم جديد';
    }
}
