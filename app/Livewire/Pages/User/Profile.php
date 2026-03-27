<?php
namespace App\Livewire\Pages\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
#[Layout('layouts.app')]
class Profile extends Component
{
    public function render()
    {
        return view('livewire.pages.user.profile');
    }
}
