<?php

namespace App\Http\Livewire\Responsable;
use Livewire\WithFileUploads;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Models\User;


class Profile extends Component
{
    use WithFileUploads;

    public $avatar;


    public function storageFunction()
    {

        if($this->avatar != null)
        {
            return Storage::putFile('public/responsable', $this->avatar);
        }
    }

   public function submit()
   {
        $this->validate([
            'avatar'=> 'required|image|mimes:jpg,jpeg,png|max:5000',
        ]);


        $path = $this->storageFunction();

        //update
        $user = User::whereId(Auth::user()->id)->update(['avatar'=> $path]);

        if($user != 0)
        {
            session()->flash('validate','ok');
        }

   }

    public function render()
    {
        return view('livewire.responsable.profile');
    }
}
