<?php

namespace App\Http\Livewire\Responsable;

use App\Models\User;
use App\Models\Bancaire;
use App\Services\CompteService;
use Auth;
use App\Models\Caisse;
use Livewire\Component;

class TableCompte extends Component
{
    public $addClass, $search_compte;
    public $cptEpargne, $date_fin, $comptes;
    public $cptCourant;

    public function mount()
    {
    
        $this->comptes = User::find(Auth::user()->id)->comptes;
        $this->addClass = 0;
    }
    


    protected $listeners = ['lockAccount'];


    public function lockAccount($id)
    {
       return Bancaire::whereId($id)->update(['etat'=>false, 'date_fin'=>date('d-m').'-'.(date('Y')+1)]);
    }


    public function closeAccount($id)
    {

        return Bancaire::whereId($id)->update(['etat'=>false, 'date_fin'=>date('d')."-".(date('m'))."-".date('Y')]);
    }




    public function activeAccount($id)
    {
       return  Bancaire::whereId($id)->update(['etat'=>true]);
    }



    public function freezeAccount($id)
    {
        $this->cptEpargne = Bancaire::find($id);

        return $this->cptEpargne;
    }

    public function closedAccount($id)
    {
        $this->cptCourant = Bancaire::find($id);
    }

    public function updated()
    {
        $this->comptes = CompteService::SearchCompte($this->search_compte);

        if(empty($this->comptes) and strlen($this->search_compte)>0)
        {
            session()->flash('message', 'aucun compte n\'a été trouvé.');
        }
        elseif(empty($this->comptes) and strlen($this->search_compte) == 0)
        {
            $this->comptes =  User::find(Auth::user()->id)->comptes;
            
        }else{
            $this->comptes = CompteService::SearchCompte($this->search_compte);
        }

    }

    public function renumeration()
    {
        $comptes = Bancaire::all();

        $caisse = Caisse::where('numAgence', Auth::user()->numAgence)->first();
        foreach($comptes as $compte):
        
            if($compte->type == 'courant')
            {
                if(date('d-m-Y') == date('d-m-Y', strtotime($compte->renumeration)) and ($compte->solde - 2000) < 2000)
                {
                  session()->flash('msgRenum', 'Le compte non effectué pour le compte '.$compte->numCompte);
                }elseif(date('d-m-Y') == date('d-m-Y', strtotime($compte->renumeration))  and ($compte->solde - 2000) >= 2000){
                    //renumeration chaque 3 mois
                    $renumeration= $compte->update(['solde_prec'=> $compte->solde, 'solde'=> $compte->solde - 5000,
                     'renumeration'=> date('d').'-'.(date('m')+3).'-'.date('Y')]);
                    
                     if($renumeration)
                     {
                             //ajout dans la caisse
                             $caisse->update(['montant_prec'=> $caisse->montant, 'montant'=> $caisse->montant+5000]);
                     }
                    break;
                }
            }

            if($compte->type == 'epargne')
            {
                if(date('d-m-Y') == date('d-m-Y', strtotime($compte->renumeration)) and ($compte->solde - 2000) < 2000)
                {
                    session()->flash('msgRenum', 'Le compte non effectué pour le compte '.$compte->numCompte);
                }
                elseif(date('d-m-Y') == date('d-m-Y', strtotime($compte->renumeration)) and ($compte->solde - 2000) >= 2000){
                    //renumeration chaque 3 mois
                   $renumeration= $compte->update(['solde_prec'=> $compte->solde, 'solde'=> $compte->solde - 2000,
                      'renumeration'=> date('d').'-'.date('m').'-'.(date('Y')+1)]);

                      if($renumeration)
                      {
                          //ajout dans la caisse
                            $caisse->update(['montant_prec'=> $caisse->montant, 'montant'=> $caisse->montant+5000]);
                      }
                break;
                }
                
            }
        endforeach;
    }


    public function actualize()
    {

        //supprimer compte
        $comptes = Bancaire::whereType('courant')->get();

        foreach($comptes as $compte):
            if(date('d-m-Y') == date('d-m-Y', strtotime($compte->date_fin)))
            {
                $compte->destroy($compte->id);
            break;
            }
        endforeach;


         // verifier la date d'echeance
         endDate($this->comptes);
         $this-> renumeration();
    }


    public function submit($id)
    {
        $this->validate([
            'date_fin'=>'required|date'
        ]);

       $bool = Bancaire::whereId($id)->update(['date_fin'=> $this->date_fin, 'etat'=> false]);
 
    }

    public function render()
    {
        return view('livewire.responsable.table-compte');
    }
}
