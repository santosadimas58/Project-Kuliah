<?php
namespace App\Livewire\Pages\Program;
use Livewire\Component;
use Livewire\Attributes\Layout;
#[Layout('layouts.app')]
class Teacher extends Component
{
    public function render()
    {
        return view('livewire.pages.program.teacher');
    }
}
