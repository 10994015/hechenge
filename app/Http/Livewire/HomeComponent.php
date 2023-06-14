<?php

namespace App\Http\Livewire;

use App\Models\Article;
use App\Models\Banner;
use App\Models\Course;
use Livewire\Component;

class HomeComponent extends Component
{
    public $popularCourseLength = 10;
    public function render()
    {
        $banners = Banner::where('hidden', false)->orderby('updated_at', 'desc')->get();
        $hotCourses = Course::where([['hidden', false], ['is_full', false]])->orderby('visitor', 'desc')->get();
        $articles = Article::where('hidden', false)->orderby('updated_at', 'desc')->get()->take(3);
        return view('livewire.home-component', ['banners'=>$banners, 'hotCourses'=>$hotCourses, 'articles'=>$articles])->layout('layouts.base');
    }
}
