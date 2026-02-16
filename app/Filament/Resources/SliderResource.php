<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Filament\Resources\SliderResource\RelationManagers;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Translations')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('O\'zbekcha')
                            ->schema([
                                Forms\Components\TextInput::make('title.uz')
                                    ->label('Title (UZ)')
                                    ->required(),
                                Forms\Components\Textarea::make('subtitle.uz')
                                    ->label('Subtitle (UZ)')
                                    ->rows(2),
                            ]),
                        Forms\Components\Tabs\Tab::make('Русский')
                            ->schema([
                                Forms\Components\TextInput::make('title.ru')
                                    ->label('Title (RU)')
                                    ->required(),
                                Forms\Components\Textarea::make('subtitle.ru')
                                    ->label('Subtitle (RU)')
                                    ->rows(2),
                            ]),
                        Forms\Components\Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('title.en')
                                    ->label('Title (EN)')
                                    ->required(),
                                Forms\Components\Textarea::make('subtitle.en')
                                    ->label('Subtitle (EN)')
                                    ->rows(2),
                            ]),
                    ])->columnSpanFull(),

                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('sliders')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('link')
                    ->url()
                    ->label('Button Link (Optional)'),

                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),

                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active'),
                Tables\Columns\TextInputColumn::make('sort_order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order')
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
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
