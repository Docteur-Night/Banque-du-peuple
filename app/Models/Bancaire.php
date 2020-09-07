<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bancaire extends Model
{
    //

    protected $fillable = ['client_id', 'user_id', 'codePays', 'numAgence','numCompte', 'type', 'rib', 'solde','etat', 'date_fin','renumeration', 'frais_ouverture', 'frais_releve'];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function responsable(){
        return $this->belongsTo('App\Models\User');
    }

    protected $date = [
        'date_fin'
    ];
}
