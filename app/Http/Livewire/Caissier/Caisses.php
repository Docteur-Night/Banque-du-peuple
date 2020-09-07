<?php

namespace App\Http\Livewire\Caissier;

use Livewire\Component;
use App\Models\User;
use App\Models\Caisse;
use Auth;

class Caisses extends Component
{
    public $caisses;

    public function mount()
    {
        $this->caisses = User::find(Auth::user()->id)->caisses;
    }

    public function actualise()
    {
        $this->caisses = User::find(Auth::user()->id)->caisses;
    }

    public function addCaisse($id)
    {
        Caisse::create(['user_id'=>$id, 'libelle'=> 'Caisse/'.Auth::user()->numAgence.'/'.rand(0,999)]);
    }

    public function render()
    {
        return view('livewire.caissier.caisses');
    }
}
