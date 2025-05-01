<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected array|string|int $columnSpan='full';
    protected static ?int $sort=2;
 
    public function table(Table $table): Table
    {
        return $table
            ->query(
              OrderResource::getEloquentQuery()
            )
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at' ,'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                ->label(__('custom.order.order_num'))
                ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                ->label(__('custom.order.customer'))
                ->searchable(),
                Tables\Columns\TextColumn::make('grand_total')
                ->money('EGP')
                ->sortable()
                ->label(__('custom.order.grand_total')),
                Tables\Columns\TextColumn::make('status')
                ->badge()
                ->searchable()
                ->color(fn (string $state):string =>match($state){
                    'pending' => 'info',
                    'processing' => 'warning',
                    'shipped' => 'success',
                    'delivered' => 'success',
                    'canceled' => 'danger',
                })
                ->icon(
                    fn (string $state):string =>match($state){
                        'pending' => 'heroicon-m-sparkles',
                        'processing' => 'heroicon-m-arrow-path',
                        'shipped' => 'heroicon-m-truck',
                        'delivered' => 'heroicon-m-check-badge',
                        'canceled' => 'heroicon-m-x-circle',
                    }
                )->searchable()
                ->label(__('custom.order.status'))
                ,
                Tables\Columns\TextColumn::make('payment_method')
                ->searchable()
                ->sortable()
                ->label(__('custom.order.payment_method'))
                ,
                Tables\Columns\TextColumn::make('payment_status')
                ->searchable()
                ->sortable()
                ->label(__('custom.order.payment_status'))
                ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                ->label(__('custom.order.order_date'))
                ->dateTime()
                ->sortable()
                ,
            ])->heading(__('custom.order.latest'))
            ->actions([
                Action::make(__('custom.order.view'))
                ->url(fn (Order $order) :string=> OrderResource::getUrl('view' ,['record' =>$order]))
                ->icon('heroicon-m-eye')
                ->color('info')
            ]);

    }
}
