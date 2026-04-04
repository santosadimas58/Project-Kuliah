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
            if ($user->hasRole('admin')) {
                return $this->redirect('/admin/dashboard', navigate: false);
            } elseif ($user->hasRole('program')) {
                return $this->redirect('/program/teacher', navigate: false);
            }
            return $this->redirect('/user/dashboard', navigate: false);
        }
        $this->addError('email', 'Invalid credentials');
    }

    public function render()
    {
        return view('livewire.pages.auth.login');
    }
}
