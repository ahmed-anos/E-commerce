<?php

use App\Http\Middleware\Setlocale;
use App\Livewire\HomePage;
use App\Livewire\ProductBrand;
use App\Livewire\ProductCategory;
use App\Livewire\ProductSales;
use App\Livewire\ShopPage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::middleware([Setlocale::class])->group(function () {
    Route::get('/', HomePage::class)->name('home');
    Route::get('/shop', ShopPage::class)->name('shop');
    Route::get('/product/categories/{categoryId}' , ProductCategory::class)->name('filter-category');
    Route::get('product/brands/{brandId}' , ProductBrand::class)->name('filter-brand');
    Route::get('product/sales/{saleId}' , ProductSales::class)->name('filter-sale');
});
Route::get('/language/{locale}' ,function($locale){
    session()->put('locale' , $locale);
    return redirect()->back();
})->name('locale');