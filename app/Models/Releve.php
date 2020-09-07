<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Releve extends Model
{
    //
    protected $fillable = ['client_id', 'type', 'montant', 'solde_prec', 'solde_actuel'];


    /**
     * @return $this
     */
    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }
}
