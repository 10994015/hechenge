<?php

namespace App\Http\Livewire;

use App\Models\Student;
use Livewire\Component;

class StudentComponent extends Component
{
    public function render()
    {
        $students = Student::where('hidden', false)->get();
        return view('livewire.student-component', ['students'=>$students])->layout('layouts.base');
    }
}
