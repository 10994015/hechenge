<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CourseComponent extends Component
{
    public function render()
    {
        return view('livewire.course-component')->layout('layouts.base');
    }
}
