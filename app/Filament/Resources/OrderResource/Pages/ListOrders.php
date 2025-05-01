<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\OrderResource\Widgets\OrderStats;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            OrderStats::class,
        ];
    }
    public function getTabs(): array
    {
        return [
           null=>Tab::make(__('custom.order.all')),
           __('custom.order.pending')=>Tab::make()->query(fn ($query) => $query->where('status' ,'pending')),
           __('custom.order.processing')=>Tab::make()->query(fn ($query) => $query->where('status' ,'processing')),
           __('custom.order.delivered')=>Tab::make()->query(fn ($query) => $query->where('status' ,'delivered')),
           __('custom.order.shipped')=>Tab::make()->query(fn ($query) => $query->where('status' ,'shipped')),
           __('custom.order.canceled')=>Tab::make()->query(fn ($query) => $query->where('status' ,'canceled')),
        ];
    }
}
