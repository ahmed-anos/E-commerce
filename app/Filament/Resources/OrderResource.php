<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\RelationManagers\AddressRelationManager;
use App\Filament\Resources\OrderResource\Widgets\OrderStats;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?int $navigationSort = 5;

    public static function getModelLabel(): string
    {
        return __('custom.order.single_title');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('custom.order.title');
    }
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Group::make()->schema([
                Section::make(__('custom.order.order_info'))
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->preload()
                            ->required()
                            ->searchable()
                            ->label(__('custom.order.customer')),
    
                        Select::make('payment_method')
                            ->options([
                                'stripe' => 'Stripe',
                                'cod' => 'Cash on Delivery',
                                'vodafone' => 'Vodafone Cash',
                            ])
                            ->required()
                            ->searchable()
                            ->label(__('custom.order.payment_method'))
                            ,
                                
                        Select::make('payment_status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'failed' => 'Failed',
                            ])
                            ->required()
                            ->default('pending')
                            ->label(__('custom.order.payment_status')),
    
                        ToggleButtons::make('status')
                            ->options([
                                'pending' => __('custom.order.pending'),
                                'processing' => __('custom.order.processing'),
                                'shipped' => __('custom.order.shipped'),
                                'delivered' => __('custom.order.delivered'),
                                'canceled' => __('custom.order.canceled'),
                            ])
                            ->default('pending')
                            ->inline()
                            ->required()
                            ->colors([
                                'pending' => 'info',
                                'processing' => 'warning',
                                'shipped' => 'success',
                                'delivered' => 'success',
                                'canceled' => 'danger',
                            ])
                            ->icons([
                                'pending' => 'heroicon-m-sparkles',
                                'processing' => 'heroicon-m-arrow-path',
                                'shipped' => 'heroicon-m-truck',
                                'delivered' => 'heroicon-m-check-badge',
                                'canceled' => 'heroicon-m-x-circle',
                            ])
                            ->label(__('custom.order.status')),
    
                        Select::make('currency')
                            ->options([
                                'EGP' => 'EGP',
                                'USD' => 'USD',
                            ])
                            ->default('EGP')
                            ->label(__('custom.order.currency')),
    
                        Textarea::make('notes')
                            ->columnSpanFull()
                            ->label(__('custom.order.notes')), 
                    ])
                    ->columns(2) ,
                    Section::make(__('custom.order.order_items'))->schema([
                        Repeater::make('items')->relationship()->label(__('custom.order.items'))
                        ->schema([
                            Select::make('product_id')->relationship('product' ,'name')
                            ->searchable()->preload()->required()->distinct()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $product = \App\Models\Product::find($state);
                                    if ($product) {
                                        $set('unit_amount', $product->price); 
                                    }
                                }
                            })
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $product = \App\Models\Product::find($state);
                                    if ($product) {
                                        $set('total_amount', $product->price); 
                                    }
                                }
                            })
                            ->label(__('custom.order.product'))
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                            ->columnSpan(4),
                            TextInput::make('quantity')->required()
                            ->numeric()
                            ->minValue(1)
                            ->default(1)
                            ->columnSpan(2)
                            ->reactive()
                            ->afterStateUpdated(function($state ,callable $set ,callable $get){
                                $set('total_amount' , $state * $get('unit_amount'));
                            })
                            ->label(__('custom.order.quantity'))
                            ,
                            TextInput::make('unit_amount')
                            ->numeric()
                            ->required()
                            ->readOnly()
                            ->dehydrated()
                            ->columnSpan(3)
                            ->label(__('custom.order.unit_amount'))
                            ,
                            TextInput::make('total_amount')
                            ->numeric()
                            ->required()
                            ->dehydrated()
                            ->columnSpan(3)
                            ->label(__('custom.order.total_amount'))

                        ])->columns(12),

                        Placeholder::make('Total Grand Amounts')
                        ->label(__('custom.order.grand_total'))
                        ->content(function (callable $get, callable $set ){
                            $total = 0;
                            $items = $get('items');
                            if (is_array($items)) {
                                foreach ($items as $item) {
                                    $quantity = isset($item['quantity']) ? (int) $item['quantity'] : 0;
                                    $unitAmount = isset($item['unit_amount']) ? (float) $item['unit_amount'] : 0;
                                    $total += $quantity * $unitAmount;
                                }
                            }
                            $set('grand_total' ,$total);
                         return number_format($total, 2) . ' EGP';
                        })
                    ]),
                    Hidden::make('grand_total')->default(0)

            ])->columnSpanFull()
        ]);
    
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label(__('custom.order.customer'))
                ->sortable()
                ->searchable(),

                TextColumn::make('grand_total')->label(__('custom.order.grand_total'))
                ->numeric()
                ->money('EGP')
                ->sortable()
                ->searchable(),

                TextColumn::make('payment_method')->label(__('custom.order.payment_method'))
                ->sortable()
                ->searchable(),
                TextColumn::make('payment_status')->label(__('custom.order.payment_status'))
                ->sortable()
                ->searchable(),

                SelectColumn::make('status')->label(__('custom.order.status'))
                ->options([
                    'pending' => 'Pending',
                    'processing' => 'Processing',
                    'shipped' => 'Shipped',
                    'delivered' => 'Delivered',
                    'canceled' => 'Canceled',
                ])
                ->searchable()
                ->sortable(),

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
           AddressRelationManager::class
        ];
    }
    public static function getWidgets(): array
    {
        return [
            OrderStats::class,
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() >10 ? 'success' : 'danger';
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
