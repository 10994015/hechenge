<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TeacherComponent extends Component
{
    public function render()
    {
        return view('livewire.teacher-component')->layout('layouts.base');
    }
}
