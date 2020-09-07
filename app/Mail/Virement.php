<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Virement extends Mailable
{
    use Queueable, SerializesModels;

    protected $compte;
    /**
     * Create a new message instance.
     *@param App\Models\Bancaire $compte
     * @return void
     */
    public function __construct($compte)
    {
        //

        $this->compte = $compte;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      try{
          if($this->compte != NULL)
          {
            return $this->markdown('email.virement')->withCompte($this->compte);
          }
      }catch(Exception $e){
          
           return abort(404);
      }
       
    }
}
