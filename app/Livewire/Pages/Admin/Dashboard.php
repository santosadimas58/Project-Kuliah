<?php
namespace App\Livewire\Pages\Admin;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use Spatie\Permission\Models\Role;
#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.pages.admin.dashboard', [
            'totalUsers' => User::count(),
            'totalRoles' => Role::count(),
        ]);
    }
}
