<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Setting extends Model
{
    use HasTranslations;
    protected $fillable=[
        'name',
        'logo',
        'phone_number',
        'city',
        'country',
        'street',
        'email',
        'social_links'
    ];
    // public array $translatable= [
    //     'name',
    //     'city',
    //     'country',
    //     'street',
    //     'social_links'
    // ];

    protected $casts=[
        'social_links'=>'array'
    ];
}
