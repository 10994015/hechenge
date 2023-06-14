<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;

class NewsComponent extends Component
{
    use WithPagination;

    public $search;
    public $range;
    public function mount(){
        $this->range = "month";
    }
    public function chengRange($range){
        $this->range = $range;
    }
    public function render()
    {
        if($this->range == "month"){
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
    
            $articles = Article::where([['hidden', false],['title', 'like', "%$this->search%"]])->orWhere([['hidden', false],['content', 'like', "%$this->search%"]])->whereBetween('updated_at', [$startDate, $endDate])->orderby('updated_at', 'desc')->paginate(3);
        }else{
            $articles = Article::where([['hidden', false],['title', 'like', "%$this->search%"]])->orWhere([['hidden', false],['content', 'like', "%$this->search%"]])->orderby('updated_at', 'desc')->paginate(3);
        }
        
        return view('livewire.news-component', ['articles'=>$articles])->layout('layouts.base');
    }
}
