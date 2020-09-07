<?php

namespace App\Http\Livewire;
use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\User;

class Avatar extends Component
{
    use WithFileUploads;

    public $avatar;

    protected $listeners = ['save'];

    public function save(){

    }
    public function render()
    {
        return view('livewire.avatar');
    }
}
