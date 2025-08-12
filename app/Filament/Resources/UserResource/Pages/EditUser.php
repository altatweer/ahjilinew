<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('حذف المستخدم')
                ->requiresConfirmation()
                ->modalHeading('تأكيد حذف المستخدم')
                ->modalDescription('هل أنت متأكد من حذف هذا المستخدم؟ هذا الإجراء لا يمكن التراجع عنه.')
                ->modalSubmitActionLabel('نعم، احذف'),
        ];
    }
    
    protected function getSavedNotificationTitle(): ?string
    {
        return 'تم تحديث بيانات المستخدم بنجاح';
    }
    
    public function getTitle(): string
    {
        return 'تحرير: ' . $this->record->display_name;
    }
}
