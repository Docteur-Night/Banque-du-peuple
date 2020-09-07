<?php

namespace App\Http\Livewire\Caissier;
use App\Models\Client;
use  App\Services\ClientService;
use App\Models\Bancaire;
use App\Models\Caisse;
use Auth;
use App\Models\Releve;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\Sms;
use Livewire\Component;




class Depot extends Component
{
    public $search, $clients, $client, $caisses;

    public $nCompte, $idClient, $montant, $caisse;
    public $fraisMsg;

    public function mount()
    {
        $this->clients = Client::all();
        $this->caisses = User::find(Auth::user()->id)->caisses;
        $this->fraisMsg = 250;
    }
    

    public function copy($id)
    {
      
        $this->client = Client::find($id);
        
        $this->clients =  Client::all();
        
        if($this->client)
        {
            $this->idClient = $this->client['identifiant'];

            $compte = Client::find($this->client['id'])->compte;

            if($compte)
            {
                $this->nCompte = $compte['numCompte'];
            }
        }
      

    }

    public function updated()
    {

        $this->clients =  ClientService::searchClient($this->search);

        if(empty($this->clients) and strlen($this->search) > 0){
            session()->flash('message', 'Aucun client n\'a été trouvé.');
        }elseif(empty($this->clients) and strlen($this->search) == 0)
        {
            $this->clients =  Client::all();
        }

    }

    public function traitementDepot($compte, $client)
    {
        $caisse = Caisse::whereLibelle($this->caisse)->first();

        if($caisse)
        {

            if($compte->type == 'epargne' and $compte->date_fin != NULL)
            {
                session()->flash('error', 'impossible de faire un depôt, patientez jusqu\'à la date d\'écheance');
            }elseif(($compte->solde + $this->montant - $compte->frais_ouverture - $this->fraisMsg)< 2000){
                session()->flash('error', 'Le montant ne suffit pas pour payer les frais d\'ouverture');
            } 
            else{
                $depot = $compte->update(['solde_prec'=> $compte->solde, 'solde'=> ($compte->solde + $this->montant - $compte->frais_ouverture - $compte->frais_releve - $this->fraisMsg)]);
                        
                    Releve::create([
                        'client_id' => $client->id,
                        'type'=> 'depôt',
                        'montant'=> $this->montant,
                        'solde_prec' => $compte->solde_prec,
                        'solde_actuel'=> $compte->solde,
                    ]);

                $versement = $caisse->update(['montant_prec'=> $caisse->montant, 'montant'=> $caisse->montant + $this->montant]);
                if(($depot and $versement) == 1)
                {

                    //INITIALISATION DES FRAIS (le client ne doit plus)
                    $compte->update(['frais_ouverture'=> NULL]);

                    session()->flash('sent', 'Le depôt a été effectué avec succès');

                    //session pour pdf
                     session(['compte'=> $compte]);
                     session(['montant'=> $this->montant]);
                     session(['operation'=> "depôt"]);
                     session(['client'=> $client]);

                    return Mail::to($client->email)->send(new Sms($client, 'depôt', $this->montant));
                }
                // Ajout du montant dans la caisse
            }
        }
    }

    public function submit()
    {
        $this->validate([
           'nCompte'=>'required|max:11',
           'idClient'=>'required|max:9',
           'montant'=>'required|numeric',
           'caisse'=>'required',
        ]);

        $client = Client::whereIdentifiant($this->idClient)->first();
        $compte = Bancaire::whereNumcompte($this->nCompte)->first();

        if($client != NULL and $compte !=NULL)
        {

            if($compte->client_id == $client->id){
                //traiment de depot
               $this-> traitementDepot($compte, $client);
            }else{
                session()->flash('unknown', 'Le numéro du compte n\'appartient pas à cet identifiant.');
            }

        }else{
            session()->flash('unknown', 'Impossible de traiter cette Opération.');
        }
    }
    public function render()
    {
        return view('livewire.caissier.depot');
    }
}
