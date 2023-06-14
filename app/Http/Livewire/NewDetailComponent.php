<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;

class NewDetailComponent extends Component
{
    public $slug;
    public function mount($slug){
        $this->slug = $slug;
    }
    public function render()
    {
        $article = Article::where('slug', $this->slug)->first();
        return view('livewire.new-detail-component', ['article'=>$article])->layout('layouts.base');
    }
}
