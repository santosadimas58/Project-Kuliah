<?php
namespace App\Livewire\Pages\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
class Login extends Component
{
    public $email = '';
    public $password = '';
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
