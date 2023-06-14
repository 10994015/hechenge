<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CourseComponent extends Component
{
    public $category_id;
    public $search;
    public function mount($category){
        $this->category_id = $category;
    }
    public function render()
    {
        $courseCategoies = CourseCategory::all();
        $courses = Course::where([['hidden', false], ['category_id', $this->category_id]])->where('title', 'like', "%$this->search%")->orderby('updated_at', 'desc')->get();
        return view('livewire.course-component', ['courses'=>$courses, 'courseCategoies'=>$courseCategoies])->layout('layouts.base');
    }
}
