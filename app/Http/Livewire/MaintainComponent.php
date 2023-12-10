<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MaintainComponent extends Component
{
    public function render()
    {
        return view('livewire.maintain-component')->layout('layouts.maintain');;
    }
}
