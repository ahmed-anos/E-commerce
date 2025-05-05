<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On; 

class ShopPage extends Component
{
    use WithPagination;
    public $products;
    public $amount=4;
 
    public function loadMore()
    {
        $this->amount += 4;
    }

   

public function filterByCategory($categoryId)
{
    $this->products = Product::where('category_id', $categoryId)->take($this->amount)->get();
}
    public function render()
    {
        $categories=Category::all();
        $brands=Brand::all();
        $this->products=Product::take($this->amount)->get();
        return view('livewire.shop-page', [
            'categories' => $categories,
            'brands' => $brands,
            'products' => $this->products,
        ])->extends('layouts.master');
    }
}
