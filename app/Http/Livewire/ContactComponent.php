<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ContactComponent extends Component
{
    public $name;
    public $email;
    public $subject;
    public $content;
    public $captcha;
    public function reload(){
        return response()->json(['captcha'=>captcha_img()]);
    }
    public function onSubmit(){
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'content' => 'required',
            'captcha' => 'required|captcha',
        ]);
    }
    public function render()
    {
        return view('livewire.contact-component')->layout('layouts.base');
    }
}
