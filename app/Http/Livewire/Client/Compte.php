<?php

namespace App\Http\Livewire\Client;

use Livewire\Component;
use App\Models\Client;
use App\Nodels\Bancaire;
class Compte extends Component
{
    public $client, $compte, $client_id;


    protected $listeners = ['GetPapperView'];
    public function mount()
    {
        if(session()->has('client_id'))
        {
            $this->client = Client::find(session('client_id')) ?? NULL;
            $this->compte = Client::find(session('client_id'))->compte?? NULL;

        }
    }
    
    public function GetPapperView()
    {

    }

    public function logout()
    {
        if(session()->has('client_id')){
           session()->forget('client_id');

           return redirect()->route('account',['client'=>0]);
        }
    }

    public function submit()
    {
        $this->validate([
            'client_id'=>'required|max:9'
        ]);

        $client = Client::whereIdentifiant($this->client_id)->first();

        if($client){
            session(['client_id' => $client['id']]);
            session()->flash('success','vous êtes connecté');
            return redirect()->route('account',['client'=>session('client_id')]);
        }else{
            session()->flash('error', 'nous n\'arrivons pas à nous connecté');
        }
    }
    
    public function render()
    {
        return view('livewire.client.compte');
    }
}
