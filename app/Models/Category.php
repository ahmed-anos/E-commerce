<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations;
    protected $fillable=['name' ,'slug' ,'image' ,'is_active'];

    public array $translatable= [
        'name',
        'slug'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
