<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Mail\UserRegisteredMail;
use App\Models\Teacher;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class RegisterAccountController extends Controller
{
    public function __invoke(Request $request)
    {
        $teacher = Teacher::whereIdentifier($request->identifier)->first();

        if (!$teacher) {
            Alert::error('No existe algún usuario con el identificador solicitado.');
            return redirect()->back();
        }

        if (User::whereIdentifier($request->identifier)->verified()->exists()) {
            Alert::error('Ya existe una cuenta con el identificador solicitado.');
            return redirect()->back();
        }
        
        if(User::whereNotIdentifier($request->identifier)->whereEmail($teacher->email)->exists()){
            Alert::error("Ya existe una cuenta con el correo: $teacher->email ingresado.");
            return redirect()->back();
        }

        $password = Str::random();
        
        $user = User::updateOrCreate([
            'identifier' => $teacher->identifier
        ], [
            'name' => strtoupper($teacher->name),
            'password' => bcrypt($password),
            'email' => $teacher->email,
        ])->assignRole(Role::TEACHER_ROLE);

        Mail::to($teacher->email)
            ->send(new UserRegisteredMail($user, $password));

        Alert::success('¡Usuario registrado!', 'Se ha enviado un correo electrónico para validar tu registro');
        return redirect()->route('login');
    }
}
