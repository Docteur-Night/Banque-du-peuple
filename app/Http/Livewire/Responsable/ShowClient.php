<?php

namespace App\Http\Livewire\Responsable;
use Livewire\Component;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ShowClient extends Component
{

    public $clients, $compte;

   
    public function mount()
    {
   
        $this->clients= User::find(Auth::user()->id)->clients;
    }


    public function takeAccount($id) 
    {  
        $this->compte = Client::find($id)->compte;
        
        return $this->compte;
    }


    public function render()
    {

        return view('livewire.responsable.show-client');
    }
}
