<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use HasTranslations;
    protected $fillable=[
        'image',
        'description',
        'title',
        'order'
    ];

    public array $translatable= [
        'description',
        'title'
    ];
}
