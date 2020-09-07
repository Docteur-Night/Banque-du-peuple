<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{
    //

    protected $fillable = ['user_id','libelle', 'montant', 'montant_prec'];

    /**
     * @return $this
     */

     public function Caissier()
     {
         return $this->belongsTo('App\Models\User');
     }
}
