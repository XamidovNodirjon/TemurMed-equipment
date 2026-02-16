<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $nameTranslations = $this->record->getTranslations('name');
        $descTranslations = $this->record->getTranslations('description');
        
        $data['name_uz'] = $nameTranslations['uz'] ?? '';
        $data['name_ru'] = $nameTranslations['ru'] ?? '';
        $data['name_en'] = $nameTranslations['en'] ?? '';

        $data['description_uz'] = $descTranslations['uz'] ?? '';
        $data['description_ru'] = $descTranslations['ru'] ?? '';
        $data['description_en'] = $descTranslations['en'] ?? '';

        // Pre-fill category_id for dependent select
        if ($this->record->subCategory) {
            $data['category_id'] = $this->record->subCategory->category_id;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['name'] = [
            'uz' => $data['name_uz'],
            'ru' => $data['name_ru'],
            'en' => $data['name_en'],
        ];

        $data['description'] = [
            'uz' => $data['description_uz'] ?? '',
            'ru' => $data['description_ru'] ?? '',
            'en' => $data['description_en'] ?? '',
        ];

        unset(
            $data['name_uz'], $data['name_ru'], $data['name_en'],
            $data['description_uz'], $data['description_ru'], $data['description_en'],
            $data['category_id'] // Don't save category_id to product
        );

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
