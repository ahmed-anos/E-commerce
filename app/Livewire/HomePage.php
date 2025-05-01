<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Order;
use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        $categories=Category::get();
        $orders=Order::get();
        return view('livewire.home-page' ,compact('categories', 'orders'))->extends('layouts.master');
    }
}
