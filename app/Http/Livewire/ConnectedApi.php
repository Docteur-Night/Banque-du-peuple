<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class ConnectedApi extends Component
{
    public $numAgence, $valide, $service;

    public function mount()
    {
        $this->valide =0;
    }

    public function submit()
    {
        $this->validate([
            'numAgence'=>'required|max:5',
            'service'=>'required'
        ]);

        $update = User::where(['id'=>Auth::user()->id])->update(['numAgence'=> $this->numAgence, 'service'=> $this->service]);

        if($update)
        {
            $this->valide =1;
            redirect()->home();
        }

    }
   
    public function render()
    {
        return view('livewire.connected-api');
    }
}
