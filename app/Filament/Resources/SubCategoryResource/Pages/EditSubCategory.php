<?php

namespace App\Filament\Resources\SubCategoryResource\Pages;

use App\Filament\Resources\SubCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubCategory extends EditRecord
{
    protected static string $resource = SubCategoryResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $translations = $this->record->getTranslations('name');
        
        $data['name_uz'] = $translations['uz'] ?? '';
        $data['name_ru'] = $translations['ru'] ?? '';
        $data['name_en'] = $translations['en'] ?? '';

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['name'] = [
            'uz' => $data['name_uz'],
            'ru' => $data['name_ru'],
            'en' => $data['name_en'],
        ];

        unset($data['name_uz'], $data['name_ru'], $data['name_en']);

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
