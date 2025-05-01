<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Actions\CreateAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Table;
use function PHPUnit\Framework\matches;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                ->label(__('custom.order.order_num'))
                ->searchable(),
                Tables\Columns\TextColumn::make('grand_total')
                ->money('EGP')
                ->label(__('custom.order.grand_total'))
                ,
                Tables\Columns\TextColumn::make('status')
                ->badge()
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
                ->label(__('custom.order.payment_method')),
                Tables\Columns\TextColumn::make('payment_status')
                ->searchable()
                ->sortable()
                ->badge()
                ->label(__('custom.order.payment_status')),
                Tables\Columns\TextColumn::make('created_at')
                ->label(__('custom.order.order_date'))
                ->dateTime()
                ->sortable()
                ,
                

                // Tables\Columns\TextColumn::make(''),
                // Tables\Columns\TextColumn::make('id'),
            ])
            ->heading(__('custom.order.label'))
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Action::make(__('custom.order.view'))
                ->url(fn (Order $record):string =>OrderResource::getUrl('view' ,['record' => $record]))
                ->color('info')
                ->icon('heroicon-m-eye'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
