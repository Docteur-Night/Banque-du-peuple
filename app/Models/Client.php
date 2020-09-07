<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $fillable = ['nom', 'user_id', 'prenom', 'adresse', 'email', 
    'profession', 'salaire', 'tel', 'infos', 'avatar', 'identifiant', 'numAgence', 'frais_ouverture'];


    /**
     * One To Many inversed
     * @return $this
     */
        public function user(){
            return $this->belongsTo('App\Models\User');
        }

        /** 
         * @return $this
         */
         public function compte()
         {
             return $this->hasOne('App\Models\Bancaire');
         }


        /**
         * 
         * @return $this
         * 
         * 
        */
         public function releves()
         {
             return $this->hasMany('App\Models\Releve');
         }
}
