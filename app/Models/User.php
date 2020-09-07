<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom', 'prenom', 'identifiant', 'service', 'numAgence', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * One To Many 
     * @return $this
     */
    public function clients(){
        return $this->hasMany('App\Models\Client');
    }

    /**
     * OneToMany
     * @return $this
     */
    public function comptes(){
        return $this->hasMany('App\Models\Bancaire');
    }


    /**
     * @return $this
     */

     public function caisses()
     {
         return $this->hasMany('App\Models\Caisse');
     }
}
