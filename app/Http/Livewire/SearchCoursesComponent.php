<?php

namespace App\Http\Livewire;

use App\Models\Course;
use Livewire\Component;

class SearchCoursesComponent extends Component
{
    public $value;
    public function mount($value){
        $this->value = $value;
    }
    public function render()
    {
        $courses = Course::where([['hidden', false], ['title', 'like', "%$this->value%"]])->orWhere([['hidden', false], ['content', 'like', "%$this->value%"]])->orderby('updated_at', 'desc')->get();
        return view('livewire.search-courses-component', ['courses'=>$courses])->layout('layouts.base');
    }
}
