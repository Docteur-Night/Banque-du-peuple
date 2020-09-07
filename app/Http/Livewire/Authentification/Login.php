<?php

namespace App\Http\Livewire\Authentification;

session_start();
use Livewire\Component;
use App\Models\User;
use App\Models\Client;
use Auth;
class Login extends Component
{
    public $idUser, $code, $collapse, $agence;
    public $systemClick;

    protected const CODE = "LARAVEL";

    public function mount(){
      $this->collapse;
      $systemClick;
    }

    public function testCode()
    {
        if($this->code == Login::CODE)
        {
            return redirect()->route('register');
        }else{
            session()->flash('error', 'is-invalid');
        }
    }

    public function collapse()
    {
        $this->systemClick++;

        if($this->systemClick % 2){
            return $this->collapse = 1;
        }else{
            return  $this->collapse = 0;
        }
     
    }

    public function Find(array $data){
       
    }


    public function submit(){
       $this->validate([
            'idUser'=>'required|string',
            'agence'=>'required|string',

       ]);

       $user = User::where(['identifiant'=> $this->idUser, 'numAgence' => $this->agence])->first();
       if($user)
       {
           Auth::login($user, true);

           if($user->service == 'Gestion de compte')
           {
               return redirect()->route('gestion.show',['numAgence'=> $user->numAgence, 'id'=>$user->id]);
           }else{
              return redirect()->route('operation.show',['numAgence'=> $user->numAgence, 'id'=>$user->id]);   
           }

       }
       else{
           session()->flash('message', 'Nous n\'avons pas pu trouver cet identifiant');
       }
    }


    public function render()
    {
        return view('livewire.authentification.login');
    }
}
