<?php

namespace App\Http\Livewire\Responsable;

use Illuminate\Support\Str;
use App\Services\SearchClientService;
use App\Models\Bancaire;
use App\Models\Client;
use Livewire\Component;
use Flashy;
use Illuminate\Support\Facades\Auth;

class CreateCardBank extends Component
{
    public $numCompte, $rib, $codepays, $numAgence, $type, $search, $frais;
    public $client, $idC, $state;

    public $social, $adresse, $employeur, $identifiant;

    


    protected $listeners=['submit', 'stateOpen','Type'];

    public function mount()
    {
        
        // epargne 
        $this->numAgence = Auth::user()->numAgence;
        $this->codepays = 'SN';
        $this->numCompte = rand(0,9999999999).''.strtoupper(Str::random(1)); 
        $this->rib = rand(0,99);

        $this->idC = Client::where('user_id', Auth::user()->id)->max('id');
        $this->client = Client::find($this->idC);

        //state Frais Compte epargne

        $this->state = 0;

        //courant 

        $this->identifiant =  rand(0,9999999999);

 
    }




    public function updated()
    {
        if($this->type == 'courant')
        {
             $this->state = 0;
        }
            if($this->type == 'epargne')
            {
                 $this->social = $this->adresse = $this->employeur = '';
            }
        

        if($this->type == 'epargne')
        {
            $this->frais = 1750;
        }elseif($this->type == 'bloqué'){
            $this->frais = 2000;
        }
    }

    public function validation()
    {
        $this->validate([
            'type'=>'required',
            'numCompte'=>'unique:bancaires',
            'rib'=>'unique:bancaires',
            'social'=> $this->type == 'courant'? 'required|min:4':'',
            'adresse'=> $this->type == 'courant'? 'required|min:4':'',
            'employeur'=> $this->type == 'courant'? 'required|min:4':'',
            'identifiant'=> $this->type == 'courant'? 'required':'',
        ]);
    }

    public function stateOpen()
    {
        if($this->type == 'epargne'){
            session()->flash('message', 'Vous avez confirmé les frais d\'ouverture du compte épargne.');
            return $this->state = 1;
        }

        if($this->type == 'bloqué')
        {
            session()->flash('message', 'Vous avez confirmé les frais d\'ouverture du compte bloqué.');
            return $this->state = 1;
        }
    }

    public function refreshAccount()
    {
        $this->numCompte = rand(0,9999999999).''.strtoupper(Str::random(1));
        $this->rib = rand(0,99);
    }

    public function create(array $data)
    {
        if($data != NULL){
           
            if($data['type'] == 'courant' or $data['type'] == 'epargne' or $data['type'] == 'bloqué')
            {
                return Bancaire::create([
                    'client_id'=> $this->idC,
                    'user_id'=> Auth::user()->id,
                    'numAgence'=> $data['agence'],
                    'codePays'=> $data['codepays'],
                    'numCompte'=>$data['numCompte'],
                    'rib'=> $data['rib'],
                    'type' => $data['type'],
                    'frais_ouverture' => ($this->type =='epargne' or $this->type == 'bloqué')? $this->frais: NULL,
                    'renumeration'=> $this->type=='epargne'? date('d').'-'.date('m').'-'.(date('Y')+1):($this->type=='courant'? date('d').'-'.(date('m')+3).'-'.date('Y'):''),
                ]); 
            }
        }
    }

    public function submit()
    {
        $data = [
            'agence'=> $this->numAgence,
            'codepays'=> $this->codepays,
            'numCompte' => $this->numCompte,
            'rib' => $this->rib,
            'type' => $this->type,
        ];

        //validate type
        $this->validation();

        if($this->type == 'epargne' and $this->state !=1){

            return session()->flash('error', 'Vous devez confirmer les frais d\'ouverture pour le compte épargne');

        }else if($this->type == 'courant' && $this->client['profession'] == 'etudiant'){

           session()->flash('profession','Désolé un compte courant n\'est pas valable pour un étudiant !');
        }else if($this->type == 'courant' and $this->state == 1){

            session()->flash('state','Nous signalons que les frais d\'ouverture sont confirmés');

        }else if($this->type== 'bloqué' and $this->state != 1)
        {
            return session()->flash('error', 'Vous devez confirmer les frais d\'ouverture pour le compte bloqué');
        }
        else{
           
            $compte =  $this->create($data);

            if($compte)
            {
                Flashy::message('Compte bancaire créé avec succes !');
                return redirect()->route('gestion.show',['numAgence'=> Auth::user()->numAgence, 'id'=> Auth::user()->id]);
            }
        }
    }

    public function render()
    {
        return view('livewire.responsable.create-card-bank');
    }
}
