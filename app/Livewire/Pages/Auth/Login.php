<?php
namespace App\Livewire\Pages\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
#[Layout('layouts.app')]
class Login extends Component
{
    public $email = '';
    public $password = '';

    public function mount()
    {
        if (Auth::check()) {
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
