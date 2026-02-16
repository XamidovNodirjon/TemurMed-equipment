<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
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
            $data['description_uz'], $data['description_ru'], $data['description_en']
        );

        return $data;
    }
}
