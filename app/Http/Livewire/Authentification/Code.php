<?php

namespace App\Http\Livewire\Authentification;

use Livewire\Component;

class Code extends Component
{
    public $code;

    protected const CODE = "LARAVEL";

    public function submit(){
        if($this->code == Code::CODE)
        {
            return redirect()->route('register');
        }else{
            session()->flash('error', 'is-invalid');
        }
    }
    public function render()
    {
        return view('livewire.authentification.code');
    }
}
