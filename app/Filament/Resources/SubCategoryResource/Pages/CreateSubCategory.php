<?php

namespace App\Filament\Resources\SubCategoryResource\Pages;

use App\Filament\Resources\SubCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSubCategory extends CreateRecord
{
    protected static string $resource = SubCategoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = [
            'uz' => $data['name_uz'],
            'ru' => $data['name_ru'],
            'en' => $data['name_en'],
        ];

        unset($data['name_uz'], $data['name_ru'], $data['name_en']);

        return $data;
    }
}
