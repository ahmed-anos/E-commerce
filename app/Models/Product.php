<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{

    use HasTranslations;
    protected $fillable=[
        'category_id',
        'brand_id',
        'name' ,
        'slug' ,
        'images' ,
        'is_active',
        'description',
        'price',
        'is_featured',
        'in_stock',
        'on_sale',
        'is_new',
        'quantity'
    ];

    public array $translatable= [
        'name',
        'slug',
        'description'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class ,'offer_id' ,'id');
    }

    protected $casts=[
        'images'=>'array'
    ];
}
