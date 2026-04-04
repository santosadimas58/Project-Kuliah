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
            $this->redirectRoute('admin.dashboard');
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
                $this->redirectRoute('admin.dashboard', navigate: false);
                return;
            } elseif ($user->hasRole('program')) {
                $this->redirectRoute('program.teacher', navigate: false);
                return;
            }
            $this->redirectRoute('user.dashboard', navigate: false);
            return;
        }
        $this->addError('email', 'Invalid credentials');
    }

    public function render()
    {
        return view('livewire.pages.auth.login');
    }
}
