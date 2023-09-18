<?php

namespace App\Http\Livewire\Panel;

use Livewire\Component;

class Profile extends Component
{
    public function render()
    {
        return view('livewire.panel.profile') -> layout('layouts.panel');
    }
}
