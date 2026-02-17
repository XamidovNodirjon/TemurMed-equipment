<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

// use Filament\Resources\Concerns\Translatable; // Removed for manual tabs

class ProductResource extends Resource
{
    // use Translatable;

    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return 'Продукт';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Продукты';
    }

    public static function getNavigationLabel(): string
    {
        return 'Продукты';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Категория')
                            ->options(\App\Models\Category::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),

                        Forms\Components\Tabs::make('Translations')
                            ->tabs([
                                Forms\Components\Tabs\Tab::make('O\'zbekcha')
                                    ->schema([
                                        Forms\Components\TextInput::make('name_uz')
                                            ->label('Название (UZ)')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                                        Forms\Components\RichEditor::make('description_uz')
                                            ->label('Описание (UZ)')
                                            ->nullable(),
                                    ]),
                                Forms\Components\Tabs\Tab::make('Русский')
                                    ->schema([
                                        Forms\Components\TextInput::make('name_ru')
                                            ->label('Название (RU)')
                                            ->required(),
                                        Forms\Components\RichEditor::make('description_ru')
                                            ->label('Описание (RU)')
                                            ->nullable(),
                                    ]),
                                Forms\Components\Tabs\Tab::make('English')
                                    ->schema([
                                        Forms\Components\TextInput::make('name_en')
                                            ->label('Название (EN)')
                                            ->required(),
                                        Forms\Components\RichEditor::make('description_en')
                                            ->label('Описание (EN)')
                                            ->nullable(),
                                    ]),
                            ])->columnSpanFull(),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                    ])->columns(2),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Изображение')
                            ->image()
                            ->directory('products'),
                        Forms\Components\TextInput::make('price')
                            ->label('Цена')
                            ->numeric()
                            ->prefix('$'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Активен')
                            ->required()
                            ->default(true),
                        Forms\Components\Toggle::make('is_recommended')
                            ->label('Рекомендуемый')
                            ->default(false),
                    ])->columns(2),

                Forms\Components\Section::make('Характеристики')
                    ->schema([
                        Forms\Components\KeyValue::make('specifications')
                            ->label('Параметры')
                            ->keyLabel('Параметр')
                            ->valueLabel('Значение')
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Изображение'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Категория')
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                            ->orderByRaw("categories.name->>'".app()->getLocale()."' $direction");
                    }),
                Tables\Columns\TextColumn::make('price')
                    ->label('Цена')
                    ->money()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Активен')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_recommended')
                    ->boolean()
                    ->label('Рекомендуемый'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Дата обновления')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
