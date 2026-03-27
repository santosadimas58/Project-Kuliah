cat > routes/web.php << 'EOF'
<?php

use App\Livewire\Pages\Auth\Login;
use App\Livewire\Pages\Admin\Dashboard as AdminDashboard;
use App\Livewire\Pages\Admin\Users as AdminUsers;
use App\Livewire\Pages\Admin\Program as AdminProgram;
use App\Livewire\Pages\User\Dashboard as UserDashboard;
use App\Livewire\Pages\User\Profile as UserProfile;
use App\Livewire\Pages\Program\Teacher;
use App\Livewire\Pages\Program\Subject;
use App\Livewire\Pages\Program\Schedule;
use App\Livewire\Pages\Program\Assignment;

Route::get('/', Login::class)->name('login');
Route::get('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    Route::get('/users', AdminUsers::class)->name('users');
    Route::get('/program', AdminProgram::class)->name('program');
});

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', UserDashboard::class)->name('dashboard');
    Route::get('/profile', UserProfile::class)->name('profile');
});

Route::middleware(['auth', 'role:program'])->prefix('program')->name('program.')->group(function () {
    Route::get('/teacher', Teacher::class)->name('teacher');
    Route::get('/subject', Subject::class)->name('subject');
    Route::get('/schedule', Schedule::class)->name('schedule');
    Route::get('/assignment', Assignment::class)->name('assignment');
});

