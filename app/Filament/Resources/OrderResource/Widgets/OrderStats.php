<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('custom.order.pending') ,Order::query()->where('status' ,'pending')->count()),
            Stat::make(__('custom.order.processing') ,Order::query()->where('status' ,'processing')->count()),
            Stat::make(__('custom.order.shipped') ,Order::query()->where('status' ,'shipped')->count()),
            Stat::make(__('custom.order.average') ,Number::currency(Order::query()->avg('grand_total')??0 ,'EGP')),
        ];
    }
}
