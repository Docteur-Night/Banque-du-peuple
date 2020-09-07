<?php

namespace App\Http\Livewire\Responsable;

use App\Models\Client;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Flashy;
use Illuminate\Support\Facades\Mail;
use App\Mail\OpenCompte;
use Auth;
class CreateClient extends Component
{
    use WithFileUploads;
    public $nom, $prenom, $adresse, $email, 
    $profession, $salaire, $tel, $avatar, $infos, $identifiant;



    public function mount()
    {
        //generer id
        $this->identifiant = rand(0,999999999);
        $this->avatar = $this->avatar;
        
    }

    public function validation(){
        $this->validate([
            'nom'=>'required|min:3|max:20',
            'prenom'=>'required|min:3|max:20',
            'adresse'=>'required|min:5|max:30',
            'email'=>'required|email|unique:clients',
            'profession'=>'required',
            'salaire'=> $this->profession == 'travailleur'?'required|numeric':'',
            'tel'=>'required|numeric',
            'identifiant'=>'unique:clients',
            'infos'=> $this->profession == 'travailleur'?'required|max:255':'',
            
        ]);
    }

    public function storeFile($file)
    {
        if(!empty($file))
        {
            //stockage
           return Storage::putFile('/public/clients', $this->avatar);
        }
    }

    public function create(array $data){

        if($data)
        {
             $client = Client::create([

                'user_id' => $data['fk'],
                'nom'=> $data['nom'],
                'prenom'=> $data['prenom'],
                'email'=> $data['email'],
                'adresse'=> $data['adresse'],
                'profession' => $data['profession'],
                'salaire' => $data['salaire'],
                'tel' => $data['tel'],
                'avatar' => $data['avatar'],
                'infos' => $data['infos'],
                'identifiant' => $data['id'],
                'numAgence' => $data['agence'],
                
            ]);

            Mail::to($client->email)->send(new OpenCompte($client));

            return $client;
        }
    }

    public function submit(){


        //validate
       $this->validation();
        //storage avatar 
        $path = $this->storeFile($this->avatar);


        $data = [
            'fk'=> Auth::user()->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom, 
            'email' => $this->email,
            'adresse' => $this->adresse,
            'profession' => $this->profession,
            'salaire' => $this->salaire,
            'tel' => $this->tel,
            'avatar' => $path,
            'infos'=> $this->infos,
            'id' => $this->identifiant,
            'agence' => Auth::user()->numAgence,
        ];

       //create client
       $client = $this->create($data);

       if($client != NULL)
       {
           Flashy::message('compte client créé avec succes');
           return redirect()->route('bancaire.create');
       }
    }
    public function render()
    {
        return view('livewire.responsable.create-client');
    }
}
