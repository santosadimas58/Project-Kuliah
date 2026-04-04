<?php
namespace App\Livewire\Pages\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\PermissionRegistrar;
#[Layout('layouts.app')]
class Login extends Component
{
    public $email = '';
    public $password = '';

    public function mount()
    {
        if (Auth::check()) {
            return redirect()->to('/admin/dashboard');
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
            session()->regenerate();
            
            $user = Auth::user();
            Log::info('Login success', [
                'user_id' => $user->id,
                'email' => $user->email,
                'roles' => $user->getRoleNames(),
                'session_id' => session()->getId(),
            ]);
            
            return redirect()->to('/admin/dashboard');
        }
        $this->addError('email', 'Invalid credentials');
    }

    public function render()
    {
        return view('livewire.pages.auth.login');
    }
}
