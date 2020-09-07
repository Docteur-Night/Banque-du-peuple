<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PDF;
use Auth;


class RecuController extends Controller
{

    public $data = array();
  
    public function __construct()
    {
    
    }


    public function RecuTraitement()
    { 
  
        $data = $this->data = [
            'client' => session('client'),
            'compte' => session('compte'),
            'operation' => session('operation'),
            'montant' => session('montant'),
            'caissier' => Auth::user(),
        ];


        $pdf = PDF::loadView('banque.caissier.recu.recu', compact('data'));
        return $pdf->download('recuClient.pdf');
    }
}
