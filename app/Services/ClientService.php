<?php 

namespace App\Services;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Client;
use Auth;

class ClientService{
    public static function SearchClient($value):array
    {
        return self::SearchBy('nom', $value);
    }



    public static function Clients() // tabn clients
    {
        if(Auth::user()->service == 'Comptabilité')
        {
            return Client::all();
        }else{
            return User::find(Auth::user()->id)->clients;
        }
    }

    public static function SearchBy($key, $value){     
        return collect(self::Clients())->filter(fn($client)=> Str::contains(strtolower($client[$key]), $value))->all();
    }


}