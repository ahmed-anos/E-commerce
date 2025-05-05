<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use function Laravel\Prompts\select;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    use Translatable;
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?int $navigationSort = 4;

    public static function getModelLabel(): string
    {
        return __('custom.product.single_title');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('custom.product.title');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Group::make([
                    Section::make(__('custom.product.product_info'))->schema([
                        Forms\Components\TextInput::make('name')->label(__('custom.product.name'))
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (callable $set, $state) {
                            $set('slug', Str::slug($state));
                        }),

                        Forms\Components\TextInput::make('slug')->label(__('custom.product.slug'))
                        ->required()->disabled()->dehydrated()->unique(Product::class ,'slug' ,ignoreRecord:true)
                        ->maxLength(255),

                        MarkdownEditor::make('description')
                        ->label(__('custom.product.description'))
                        ->columnSpanFull()
                        ->fileAttachmentsDirectory('products')
                    ])->columns(2),
                    Section::make(__('custom.product.images'))->schema([
                        FileUpload::make('images')
                        ->required()
                        ->multiple()->directory('products')->imageEditor()->maxFiles(5)->reorderable()
                    ])
                ])->columnSpan(2),
                Group::make()->schema([
                    Section::make(__('custom.product.price'))->schema([
                        Forms\Components\TextInput::make('price')
                        ->label(__('custom.product.price'))
                        ->required()
                        ->numeric()
                        ->prefix('EGP'),
                        Forms\Components\TextInput::make('quantity')
                        ->label(__('custom.product.quantity'))
                        ->numeric()
                        ->prefix('quantity')->nullable(),

                    ]),
                    Section::make(__('custom.product.description'))->schema([
                        Select::make('category_id')
                        ->label(__('custom.product.category'))
                        ->required()->searchable()->preload()->relationship('category' ,'name'),
                        Select::make('brand_id')
                        ->label(__('custom.product.brand'))
                        ->required()->searchable()->preload()->relationship('brand' ,'name')
                    ])
                    ->label(__('custom.product.association')),
                    Section::make(__('custom.product.status'))
                    ->label(__('custom.product.status'))
                    ->schema([
                          Forms\Components\Toggle::make('is_active')
                          ->label(__('custom.product.active'))
                         ->required()->default(true),
                         Forms\Components\Toggle::make('is_featured')
                         ->label(__('custom.product.is_featured'))
                         ->required(),
                         Forms\Components\Toggle::make('in_stock')
                         ->label(__('custom.product.on_stock'))
                         ->required()->default(true),
                         Forms\Components\Toggle::make('is_new')
                         ->label(__('custom.product.is_new'))
                        ->required(),
                    ])
                   
                    
                
                ])->columnSpan(1)
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name') ->label(__('custom.product.name'))
                ->searchable(),
            Tables\Columns\TextColumn::make('slug') ->label(__('custom.product.slug'))
                ->searchable(),
            Tables\Columns\TextColumn::make('price') ->label(__('custom.product.price'))
                ->money('EGP')
                ->sortable(),

                Tables\Columns\TextColumn::make('category.name') ->label(__('custom.product.category'))
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand.name') ->label(__('custom.product.brand'))
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active') ->label(__('custom.product.active'))
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_featured') ->label(__('custom.product.is_featured'))
                    ->boolean(),
                Tables\Columns\IconColumn::make('in_stock') ->label(__('custom.product.on_stock'))
                    ->boolean(),
                Tables\Columns\IconColumn::make('on_sale') ->label(__('custom.product.on_sale'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('quantity') ->label(__('custom.product.quantity'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at') ->label(__('custom.users.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at') ->label(__('custom.users.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')->relationship('category','name'),
                SelectFilter::make('brand')->relationship('brand','name')
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
