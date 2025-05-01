<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Filament\Resources\BrandResource\RelationManagers;
use App\Models\Brand;
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

class BrandResource extends Resource
{
    use Translatable;
    protected static ?string $model = Brand::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';
    public static function getNavigationLabel(): string
    {
        return __('custom.brand.label');
    }

    public static function getModelLabel(): string
    {
        return __('custom.brand.single_title');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('custom.brand.title');
    }
    


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Grid::make()->schema([

                        Forms\Components\TextInput::make('name')->label(__('custom.brand.name'))
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (callable $set, $state) {
                                $set('slug', Str::slug($state));
                            }),

                        Forms\Components\TextInput::make('slug')->label(__('custom.brand.slug'))
                            ->required()->disabled()->dehydrated()->unique(Brand::class ,'slug' ,ignoreRecord:true)
                            ->maxLength(255),
                    ]),
                    Forms\Components\FileUpload::make('image')->label(__('custom.brand.image'))
                        ->image()->imageEditor()->directory('brands'),

                                     
                    Forms\Components\Toggle::make('is_active')->label(__('custom.brand.active'))
                    ->required()->default(true),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('custom.brand.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')->label(__('custom.brand.slug'))
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')->label(__('custom.brand.image')),
                Tables\Columns\IconColumn::make('is_active')->label(__('custom.brand.active'))
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
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
