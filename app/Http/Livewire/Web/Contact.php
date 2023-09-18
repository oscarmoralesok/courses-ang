<?php

namespace App\Http\Livewire\Web;

use App\Notifications\ContactNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class Contact extends Component
{
    public $arrayContact, $success = false;

    public function send()
    {
        $this -> validate([
            'arrayContact.name' => 'required',
            'arrayContact.email' => 'required|email',
            'arrayContact.message' => 'required',
        ]);

        Notification::route('mail', 'contacto@allnewglobal.com') -> notify( new ContactNotification($this -> arrayContact));

        $this -> success = true;
    }

    public function render()
    {
        return view('livewire.web.contact');
    }
}
