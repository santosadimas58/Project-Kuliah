<?php
namespace App\Livewire\Pages\Admin;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
#[Layout('layouts.app')]
class Users extends Component
{
    public function render()
    {
        return view('livewire.pages.admin.users', [
            'users' => User::with('roles')->get(),
        ]);
    }
}
