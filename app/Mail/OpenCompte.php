<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OpenCompte extends Mailable
{
    use Queueable, SerializesModels;

    protected $client;
    /**
     * Create a new message instance.
     *@param App\Models\Client $client
     * @return void
     */
    public function __construct($client)
    {
        //
        $this->client = $client;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        try{
            if($this->client != NULL)
            {
                return $this->markdown('email.opencompte')->withClient($this->client);
            }
        }catch(Exception $e)
        {
            return abort(404);
        }
        
    }
}
