<?php 

namespace App\Services;
use Illuminate\Support\Str;
use App\Models\User;
use Auth;
class CompteService {

    public static function SearchCompte($value):array
    {
        return self::SearchBy('numCompte', $value);
    }



    public static function Comptes() // tabn comptes
    {
       return User::find(Auth::user()->id)->comptes;
    }

    public static function SearchBy($key, $value){     
        return collect(self::Comptes())->filter(fn($compte)=> Str::contains(strtolower($compte[$key]), $value))->all();
    }


}