<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    //
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
    
        $user = Socialite::driver('google')->stateless()->user();
      
        $find = User::where(['nom'=>$user->getName()])->first();

        if($find != NULL)
        {
            Auth::login($find, true);
            return redirect()->home();
        }else{
          $create = User::create(['nom'=>$user->getName(), 'prenom'=>"non-défini", 'identifiant'=> rand(0,999999), 'service'=>"",'numAgence'=>""]);

          if($create)
          {
            Auth::login($create, true);
            return redirect()->home();
          }
        }
    }
}
