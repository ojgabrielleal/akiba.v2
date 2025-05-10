<?php

namespace App\Livewire;

use Livewire\Component;

class Auth extends Component
{
    public function render()
    {
        return view('livewire.auth')->title("Realize o Login");
    }
}
