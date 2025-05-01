<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{

    use Translatable;
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('custom.category.single_title');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('custom.category.title');
    }
    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                Section::make([
                    Grid::make()->schema([

                        Forms\Components\TextInput::make('name')->label(__('custom.category.name'))
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (callable $set, $state) {
                                $set('slug', Str::slug($state));
                            }),

                        Forms\Components\TextInput::make('slug')->label(__('custom.category.slug'))
                            ->required()->disabled()->dehydrated()->unique(Category::class ,'slug' ,ignoreRecord:true)
                            ->maxLength(255),
                    ]),
                    Forms\Components\FileUpload::make('image')->label(__('custom.category.image'))
                        ->image()->directory('categories')->disk('public')->visibility('private')->imageEditor(),
    
                        
                    Forms\Components\Toggle::make('is_active')->label(__('custom.category.active'))
                        ->required()->default(true),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('custom.category.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')->label(__('custom.category.slug'))
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')->label(__('custom.category.image')),
                Tables\Columns\IconColumn::make('is_active')->label(__('custom.category.active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label(__('custom.users.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label(__('custom.users.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            // ->headerActions([
            //     Tables\Actions\LocaleSwitcher::make(),
            // ])

            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),

                ])
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
