<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfferResource\Pages;
use App\Filament\Resources\OfferResource\RelationManagers;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OfferResource extends Resource
{
    use Translatable;
    protected static ?string $model = Offer::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?int $navigationSort = 7;
    public static function getModelLabel(): string
    {
        return __('custom.offer.single_title');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('custom.offer.title');
    }

//     public static function afterCreate($record, array $data): void
// {
//     $record->products()->sync($data['product_ids'] ?? []);
// }

// public static function afterUpdate($record, array $data): void
// {
//     $record->products()->sync($data['product_ids'] ?? []);
// }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Grid::make()->schema([

                        Forms\Components\TextInput::make('name')->label(__('custom.offer.offer_name'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                        ->nullable()->label(__('custom.offer.offer_description')),
                        Forms\Components\Select::make('discount_type')->label(__('custom.offer.type'))
                            ->nullable()->options([
                                'fixed' => __('custom.offer.fixed'),
                                'percentage' => __('custom.offer.percentage'),
                            ])
                            ->reactive()

                            ->required()
                            ->afterStateUpdated(fn ($state , callable $set)=>$set('discount_type' ,$state)),
                        
                            Forms\Components\TextInput::make('discount_price')->label(__('custom.offer.offer_discount'))
                            ->required()
                            ->suffix(fn ($get) => $get('discount_type') == 'percentage' ? '%' : __('custom.offer.currency'))
                            ->numeric(),
                           
                        Forms\Components\Select::make('categories_ids')->label(__('custom.offer.applies_to'))
                            ->nullable()->searchable()->multiple()->preload()
                            ->options(Category::pluck('name','id')),
                          
                            Forms\Components\Select::make('products')
                            ->relationship('products', 'name')
                            ->label(__('custom.offer.products'))
                            ->searchable()
                            ->required()
                            ->multiple()
                            ->preload(),

                        // Forms\Components\Select::make('product_ids')
                        // ->label(__('custom.offer.products'))
                        // ->required()
                        // ->searchable()
                        // ->multiple()
                        // ->preload()
                        // ->options(Product::pluck('name', 'id')->toArray()),
                        Forms\Components\DatePicker::make('start_date')->label(__('custom.offer.start_date'))
                            ->required(),
                        Forms\Components\DatePicker::make('end_date')->label(__('custom.offer.end_date'))
                           ->required()
                          
                    ]),
              
                        
                    Forms\Components\Toggle::make('show_on_homepage')->label(__('custom.offer.appearance'))
                        ->required()->default(false),
                ]),
        
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('custom.offer.offer_name'))->searchable(),
                TextColumn::make('description')->label(__('custom.offer.offer_description')),
                TextColumn::make('discount_price')->label(__('custom.offer.offer_discount'))->searchable()->sortable(),
                IconColumn::make('show_on_homepage')->label(__('custom.offer.appearance'))
                ->boolean()
                ->searchable(),
                TextColumn::make('start_date')->label(__('custom.offer.start_date'))->sortable(),
                TextColumn::make('end_date')->label(__('custom.offer.end_date'))->sortable(),
                TextColumn::make('created_at')->label(__('custom.users.created_at'))
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->label(__('custom.users.updated_at'))
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListOffers::route('/'),
            'create' => Pages\CreateOffer::route('/create'),
            'edit' => Pages\EditOffer::route('/{record}/edit'),
        ];
    }
}
