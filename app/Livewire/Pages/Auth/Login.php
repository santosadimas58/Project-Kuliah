<?php
namespace App\Livewire\Pages\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\PermissionRegistrar;
#[Layout('layouts.app')]
class Login extends Component
{
    public $email = '';
    public $password = '';

    public function mount()
    {
        if (Auth::check()) {
            app()[PermissionRegistrar::class]->forgetCachedPermissions();
            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('user.dashboard');
        }
    }

    public function authenticate()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            app()[PermissionRegistrar::class]->forgetCachedPermissions();
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('user.dashboard');
        }
        $this->addError('email', 'Invalid credentials');
    }

    public function render()
    {
        return view('livewire.pages.auth.login');
    }
}
