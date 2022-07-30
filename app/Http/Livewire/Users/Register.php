<?php

namespace App\Http\Livewire\Users;

use App\Models\AcademicUnit;
use App\Models\Teacher;
use Livewire\Component;

class Register extends Component
{
    public $academicUnits;
    public $teacher;
    public $teacherExists = false;

    public function mount()
    {
        $this->academicUnits = AcademicUnit::get();
    }

    public function render()
    {
        return view('livewire.users.register',[
            'teacher' => $this->teacher
        ])->layout('layouts.auth');
    }

    public function searchTeacher(string $identifier)
    {
        $teacher = Teacher::where('identifier', $identifier)->first();
        
        if ($teacher) {
            $teacher->email = explode('@',$teacher->email)[0];
            return $teacher->toJson();
        }

        return null;
    }
}
