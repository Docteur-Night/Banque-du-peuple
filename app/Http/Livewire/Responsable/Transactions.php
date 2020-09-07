<?php

namespace App\Http\Livewire\Responsable;
use  App\Services\ClientService;
use Livewire\Component;
use App\Models\User;
use App\Models\Client;
use App\Models\Bancaire;
USE Illuminate\Support\Facades\Mail;
use App\Mail\Virement;
use Auth;

class Transactions extends Component
{
    public $state, $search, $clients, $compte, $emetteur, $destinataire;
    public $compteEmetteur,  $compteDestinataire, $montant, $sms;

    protected $listeners = ['displaySearch', 'takeAccount'];

    public function mount()
    {
        $this->state = 0;
        $this->montant = 0;
        $this->sms = 250;
        $this->clients = User::find(Auth::user()->id)->clients;
    }


    public function displaySearch(){
        $this->state = 1;
        $this->updated();
        return  $this->state;
    }

    //helpers 

    public function takeAccount()
    {
        $comptes = User::find(Auth::user()->id)->comptes;
        return $comptes;
    }

    public function copy($id)
    {
        // on retourne le compte copié
        $this->state = 0;

        
        $this->compte = Client::find($id)->compte;


        if(empty($this->emetteur))
        {
            $this->clients =  ClientService::searchClient($this->search);
           return  $this->emetteur = $this->compte['numCompte'];
        }else{
           
            $this->clients =  ClientService::searchClient($this->search);
          return $this->destinataire = $this->compte['numCompte'];
        }
    }


    public function updated()
    {
        $this->clients =  ClientService::searchClient($this->search);

        if(empty($this->clients) and strlen($this->search) > 0){
            session()->flash('message', 'Aucun client n\'a été trouvé.');
        }elseif(empty($this->clients) and strlen($this->search) == 0)
        {
            if(Auth::user()->service == 'Gestion de compte')
            {
                return  $this->clients = User::find(Auth::user()->id)->clients;
            }else{
                return $this->clients = Client::all();
            }

        }
    }
   

    public function transfert()
    {
        $client = Client::find($this->compteEmetteur['client_id']);


        if($this->montant > 0 and $this->montant < $this->compteEmetteur['solde'])
        {
            if(($this->compteEmetteur['solde'] - $this->montant - $this->sms) < 2000){
               return  session()->flash('error', 'ce compte court des risques de déplafonement.');                 
            }else{
                $less = Bancaire::whereId($this->compteEmetteur['id'])->update(['solde_prec'=> intval($this->compteEmetteur['solde']), 'solde'=>intval($this->compteEmetteur['solde']) - $this->montant - $this->sms]);

               $more =  Bancaire::whereId($this->compteDestinataire['id'])->update(['solde_prec'=> intval($this->compteDestinataire['solde']), 'solde'=> $this->montant + intval($this->compteDestinataire['solde'])]);

               if($less == 1 and $more == 1)
               {
                   $this->montant = 0;

                  session()->flash('sent', 'Le virement a été effectué avec succes');
                  return Mail::to($client->email)->send(new Virement($this->compteEmetteur));
               }
            }
        }else{
            if($this->montant > 0 and $this->montant > $this->compteEmetteur['solde']){
                return session()->flash('error','Le montant d\'envoi ne doit pas dépasser le solde.');
            }

            if($this->montant < 0)
            {
                return session()->flash('error','Le montant saisi ne doit pas être negatif');
            }

            if($this->montant > 0 and ($this->montant - $this->compteEmetteur['solde']) == 0)
            {
                return  session()->flash('error', 'ce compte court des risques de déplafonement.');   
            }
        }
    }
    public function submit()
    {
        $this->validate([
            'emetteur'=>'required|max:11',
            'destinataire'=> 'required|max:11',
        ]);

        $this->compteEmetteur = Bancaire::where('numCompte', $this->emetteur)->first();
        $this->compteDestinataire = Bancaire::where('numCompte', $this->destinataire)->first();

        if(($this->compteEmetteur != NULL and $this->compteDestinataire != NULL) and ($this->compteEmetteur != $this->compteDestinataire)){
          return $this->state = 2;

        }elseif(($this->compteEmetteur != NULL and $this->compteDestinataire != NULL) and ($this->compteEmetteur == $this->compteDestinataire))
        {
           return session()->flash('error', 'Les deux numéros de compte sont identiques, veuillez modifier le destinataire');
        }else{
            if($this->compteEmetteur == NULL or $this->compteDestinataire == NULL){
               return  session()->flash('error', 'veuillez revoir vos numéros de compte');
            }
        }
    }

  
    public function render()
    {
        return view('livewire.responsable.transactions');
    }
}
