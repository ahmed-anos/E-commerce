<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\User;
use Livewire\Component;

class About extends Component
{
    // public $test;
    // public $test= User::find(1)->get();
    public function render()

    {

        return view('livewire.about', [

            'posts' => User::all(),

        ]);

    }
}
