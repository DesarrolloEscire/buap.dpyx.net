<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class VerifyAccountController extends Controller
{
    public function __invoke(User $user)
    {
        $user->verify();
        Auth::login($user);

        Alert::success('Cuenta verificada');
        return redirect()->route('login');
    }
}
