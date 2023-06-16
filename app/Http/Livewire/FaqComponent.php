<?php

namespace App\Http\Livewire;

use App\Models\Faq;
use Livewire\Component;

class FaqComponent extends Component
{
    public function render()
    {
        $faqs = Faq::where('hidden', false)->get();
        return view('livewire.faq-component', ['faqs'=>$faqs])->layout('layouts.base');
    }
}
