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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Category')
                            ->options(\App\Models\Category::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),

                        Forms\Components\Tabs::make('Translations')
                            ->tabs([
                                Forms\Components\Tabs\Tab::make('Uzbek')
                                    ->schema([
                                        Forms\Components\TextInput::make('name_uz')
                                            ->label('Name (UZ)')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                                        Forms\Components\RichEditor::make('description_uz')
                                            ->label('Description (UZ)')
                                            ->nullable(),
                                    ]),
                                Forms\Components\Tabs\Tab::make('Russian')
                                    ->schema([
                                        Forms\Components\TextInput::make('name_ru')
                                            ->label('Name (RU)')
                                            ->required(),
                                        Forms\Components\RichEditor::make('description_ru')
                                            ->label('Description (RU)')
                                            ->nullable(),
                                    ]),
                                Forms\Components\Tabs\Tab::make('English')
                                    ->schema([
                                        Forms\Components\TextInput::make('name_en')
                                            ->label('Name (EN)')
                                            ->required(),
                                        Forms\Components\RichEditor::make('description_en')
                                            ->label('Description (EN)')
                                            ->nullable(),
                                    ]),
                            ])->columnSpanFull(),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                    ])->columns(2),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('products'),
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->prefix('$'),
                        Forms\Components\Toggle::make('is_active')
                            ->required()
                            ->default(true),
                        Forms\Components\Toggle::make('is_recommended')
                            ->label('Recommended')
                            ->default(false),
                    ])->columns(2),

                Forms\Components\Section::make('Content')
                    ->schema([
                        // Description moved to tabs
                        Forms\Components\KeyValue::make('specifications')
                            ->keyLabel('Parameter')
                            ->valueLabel('Value')
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                            ->orderByRaw("categories.name->>'".app()->getLocale()."' $direction");
                    }),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_recommended')
                    ->boolean()
                    ->label('Recommended'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
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
