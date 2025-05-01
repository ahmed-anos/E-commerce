<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Offer extends Model
{
    use HasTranslations;
    protected $fillable=[
        'product_id',
        'name',
        'description',
        'discount_price',
        'discount_type',
        'categories_ids',
        'product_ids',
        'start_date',
        'end_date',
        'show_on_homepage'
    ];

    public array $translatable= [
        'name',
        'description',
        'discount_type'
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    protected $casts=[
        'product_ids'=>'array',
        'categories_ids'=>'array'
    ];
}
