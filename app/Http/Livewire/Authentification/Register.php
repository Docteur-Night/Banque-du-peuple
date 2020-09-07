<?php

namespace App\Http\Livewire\Authentification;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class Register extends Component
{
    public $nom, $prenom, $identifiant, $service, $numAgence;

    public function mount()
    {
        $this->identifiant = rand(0,999999);
    }

    protected $listeners = ['submit'];

    public function validation()
    {
        return $this->validate([
            'nom'=>'required|min:4|max:30|string',
            'prenom'=>'required|min:4|max:30|string',
            'identifiant'=>'required|max:6|unique:users',
            'numAgence' => 'required|max:5',
            'service'=>'required',
        ]);
    }

    public function create($datas)
    {
        $user = User::create(['nom'=>trim(ucfirst($datas['nom'])), 'prenom'=> trim(ucfirst($datas['prenom'])),
         'identifiant'=>$datas['identifiant'], 'service'=>$datas['service'], 'numAgence'=> $datas['agence']]);

         return $user;
    }

    public function submit()
    {
        $datas = [
            'nom' => $this->nom,
            'prenom'=> $this->prenom,
            'identifiant'=>$this->identifiant,
            'service'=> $this->service,
            'agence'=> $this->numAgence,
        ];

        // validation user  
        $this->validation();

         $auth = $this->create($datas);

         if($auth)
         {
             Auth::login($auth,true);
             
             if($auth->service == 'Gestion de compte')
             {
                 return redirect()->route('gestion.show',['numAgence'=> $auth->numAgence, 'id'=>$auth->id]);
             }else{
                return redirect()->route('operation.show',['numAgence'=> $auth->numAgence, 'id'=>$auth->id]);   
             }
         }
    }
    public function render()
    {
        return view('livewire.authentification.register');
    }
}
