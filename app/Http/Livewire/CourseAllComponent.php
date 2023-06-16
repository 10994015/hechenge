<?php

namespace App\Http\Livewire;

use App\Models\Course;
use Livewire\Component;

class CourseAllComponent extends Component
{
    public function render()
    {
        $courses = Course::where('hidden', false)->orderby('updated_at', 'desc')->get();

        return view('livewire.course-all-component', ['courses'=>$courses])->layout('layouts.base');
    }
}
