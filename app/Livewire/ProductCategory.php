<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class ProductCategory extends Component
{
    public $products;
    public $amount=4;
    public $categoryId;
    public function loadMore()
    {
        $this->amount += 4;
    }
    public function mount($categoryId){
        $this->categoryId = $categoryId;
        if (!$this->categoryId) {
            abort(404, 'Category not found');
        }
    }
    public function render()
    {
        $categories=Category::all();
        $brands=Brand::all();
        $this->products = Product::where('category_id', $this->categoryId)->take($this->amount)->get();
        
        return view('livewire.product-category',[
            'categories' => $categories,
            'brands' => $brands,
            'products' => $this->products,
        ])->extends('layouts.master');
    }
}
