<?php

namespace App\Http\Livewire;

use Livewire\Component;

class HomeComponent extends Component
{
    public $popularCourseLength = 10;
    public function render()
    {
        return view('livewire.home-component')->layout('layouts.base');
    }
}
