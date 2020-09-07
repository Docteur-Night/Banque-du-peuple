<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use PDF;
class ReleveController extends Controller
{
    //

    public $frais = 500;

    /**
     * 
     * @return Illuminate\Http\Response
     * 
     */
    public function ReleveTraitement()
    {
        $releves = Client::find(session('client_id'))->releves;
        $compte = Client::find(Session('client_id'))->compte;

        if($compte->solde > $this->frais){

            $compte->update(['solde_prec'=> $compte->compte, 'solde'=> $compte->compte - $this->frais]);
            $data = [
                'client' => Client::find(session('client_id')),
                'compte' => Client::find(Session('client_id'))->compte,
            ];
    
            $pdf = PDF::loadView('banque.caissier.recu.releve', compact('releves','data'));
    
            return $pdf->download('releveClient.pdf');
        }else{
           
            $compte->update(['frais_releve'=> $this->frais]);
            $data = [
                'client' => Client::find(session('client_id')),
                'compte' => Client::find(Session('client_id'))->compte,
            ];
    
            $pdf = PDF::loadView('banque.caissier.recu.releve', compact('releves','data'));
    
            return $pdf->download('releveClient.pdf');
        }

    }
}
