<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use  App\Models\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class Sms extends Mailable
{
    use Queueable, SerializesModels;

      protected $infos, $type, $montant;
    /**
     * Create a new message instance.
     *
     * @param App\Models\Client $client
     * @return void
     */
    public function __construct($client, $operation, $solde)
    {
        //
        $this->infos = $client;
        $this->type = $operation;
        $this->montant = $solde;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->infos !=NULL){
           $client = $this->infos;

           //compte du client
           $compte = Client::find($client->id)->compte;

           return $this->markdown('email.sms')->with(['client' => $client, 'compteId'=> $compte->id,
            'typeOperation'=> $this->type, 'montant'=> $this->montant]);
        }
    }
}
