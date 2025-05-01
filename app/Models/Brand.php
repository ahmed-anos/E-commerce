<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Brand extends Model
{
    use HasTranslations;
    protected $fillable=['name' ,'slug' ,'image' ];

    public array $translatable= [
        'name',
        'slug'
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
