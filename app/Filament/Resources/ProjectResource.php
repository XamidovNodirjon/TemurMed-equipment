<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function getModelLabel(): string
    {
        return 'Проект';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Проекты';
    }

    public static function getNavigationLabel(): string
    {
        return 'Проекты';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Tabs::make('Translations')
                            ->tabs([
                                Forms\Components\Tabs\Tab::make('O\'zbekcha')
                                    ->schema([
                                        Forms\Components\TextInput::make('name.uz')
                                            ->label('Nomi (UZ)')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),
                                        Forms\Components\RichEditor::make('description.uz')
                                            ->label('Tavsif (UZ)')
                                            ->required(),
                                    ]),
                                Forms\Components\Tabs\Tab::make('Русский')
                                    ->schema([
                                        Forms\Components\TextInput::make('name.ru')
                                            ->label('Название (RU)')
                                            ->required(),
                                        Forms\Components\RichEditor::make('description.ru')
                                            ->label('Описание (RU)')
                                            ->required(),
                                    ]),
                                Forms\Components\Tabs\Tab::make('English')
                                    ->schema([
                                        Forms\Components\TextInput::make('name.en')
                                            ->label('Name (EN)')
                                            ->required(),
                                        Forms\Components\RichEditor::make('description.en')
                                            ->label('Description (EN)')
                                            ->required(),
                                    ]),
                            ])->columnSpanFull(),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\FileUpload::make('image')
                            ->label('Изображение')
                            ->image()
                            ->directory('projects'),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Дата публикации')
                            ->default(now()),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Активен')
                            ->required()
                            ->default(true),
                    ])->columns(1),
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
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderByRaw("name->>'" . app()->getLocale() . "' $direction");
                    }),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Дата публикации')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('views_count')
                    ->label('Просмотры')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Активен')
                    ->boolean(),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
