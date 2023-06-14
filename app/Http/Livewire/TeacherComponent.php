<?php

namespace App\Http\Livewire;

use App\Models\Teacher;
use Livewire\Component;

class TeacherComponent extends Component
{
    public function render()
    {
        $teachers = Teacher::where('hidden', false)->orderby('updated_at', 'asc')->get();
        return view('livewire.teacher-component', ['teachers'=>$teachers])->layout('layouts.base');
    }
}
