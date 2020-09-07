<?php

namespace App\Http\Livewire\Caissier;

use App\Models\Client;
use  App\Services\ClientService;
use App\Models\Bancaire;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Sms;
use App\Models\Caisse;
use App\Models\Releve;
use App\Models\User;
use Livewire\Component;

class Retrait extends Component
{
    public $search, $clients, $client,$caisses;

    public $nCompte, $idClient, $montant, $caisse;
    public $fraisMsg;
    public function mount()
    {
        $this->clients = Client::where('numAgence', Auth::user()->numAgence)->get();
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


    /**
     * @param App\Models\Bancaire $compte
     * @param App\Models\Client $client
     */
    protected function traitementRetrait($compte, $client)
    {
        $caisse = Caisse::whereLibelle($this->caisse)->first();


        if($this->montant < $compte->solde){
            if(($compte->solde  - $this->montant - $this->fraisMsg) < 2000)
            {      
               return session()->flash('error', 'ce compte court des risques de déplafonement');
            }elseif($caisse->montant < $this->montant){
               return  session()->flash('error', 'La caisse selectionnée possède des fonds insuffisants pour effectuer cetter opération.');
            }else{
                if(($compte->type == 'epargne' or $compte->type == 'bloqué')and $compte->date_fin != NULL)
                {
                    return  session()->flash('error', 'impossible de faire un retrait, patientez jusqu\'à la date d\'écheance');
                 }
                 else {
                    $compte->update(['solde_prec'=> $compte->solde , 'solde'=> ($compte->solde - $this->montant - $this->fraisMsg)]);
                    $caisse->update(['montant_prec'=>$caisse->montant, 'montant'=> $caisse->montant - $this->montant]);

                        Releve::create([
                            'client_id' => $client->id,
                            'type'=> 'retrait',
                            'montant'=> $this->montant,
                            'solde_prec' => $compte->solde_prec,
                            'solde_actuel'=> $compte->solde,
                        ]);

                    session()->flash('sent', 'Le retrait a été effectué avec succès');
                 
                      //session pour pdf
                      session(['compte' => $compte]);
                      session(['montant'=> $this->montant]);
                      session(['operation' => 'retrait']);
                      session(['client' => $client]);
                    //Envoie du mail
                     return  Mail::to($client->email)->send(new Sms($client, 'retrait', $this->montant));
                }
            }
        }
        elseif($this->montant > $compte->solde)
        {
            return session()->flash('error', 'impossible d\'effectuer le retrait, le montant demandé est trop élevé');
        }
    }

    public function submit()
    {
        $this->validate([
           'nCompte'=>'required|max:11',
           'idClient'=>'required|max:9',
           'montant'=>'required|numeric',
        ]);

        $client = Client::whereIdentifiant($this->idClient)->first();
        $compte = Bancaire::whereNumcompte($this->nCompte)->first();

        if($client != NULL and $compte !=NULL)
        {
            if($compte->client_id == $client->id){
                
                // traitement du retrait
                $this->traitementRetrait($compte, $client);

            }else{
                session()->flash('unknown', 'Le numéro du compte n\'appartient pas à cet identifiant.');
            }

        }else{
            
            session()->flash('unknown', 'Impossible de traiter cette Opération.');
        }
    }
    public function render()
    {
        return view('livewire.caissier.retrait');
    }
}

