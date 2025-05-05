<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Slider;
use Livewire\Component;
use Livewire\WithPagination;

class HomePage extends Component
{
    // use WithPagination;
    public $amount=4;
 
    public function loadMore()
    {
        $this->amount += 4;
    }

    public function getCategoryProducts(){
        $this->dispatch('category-filter');
    }


   
    public function render()
    {
        $categories=Category::get();
        $brands=Brand::all();
        $sliders=Slider::get();
        $offers=Offer::all();
        $products=Product::take($this->amount)->get();
        return view('livewire.home-page' ,compact('categories', 'sliders' ,'brands' ,'offers' ,'products'))->extends('layouts.master');
    }

   
}
