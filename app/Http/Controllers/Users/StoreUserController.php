<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Mail\UserRegisteredMail;
use App\Models\AcademicUnit;
use App\Models\Evaluator;
use App\Models\Role;
use App\Models\User;
use App\Src\Repositories\Application\RepositoryCreator;
use App\Src\Users\Application\SyncAcademicUnits;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class StoreUserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreUserRequest $request)
    {
        // return response()->json($request->all());

        if (User::whereIdentifier($request->identifier)->exists()) {
            Alert::error("El identificador: $request->identifier ya existe en nuestros registros");
            return redirect()->back();
        }

        $password = Str::random();
        $user = new User;
        $user->name = strtoupper($request->name);
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->identifier = $request->identifier;
        $user->password = bcrypt($password);
        $user->email_verified_at = now();
        $user->save();

        $user->assignRole($request->role);

        if (in_array(Role::find($request->role)->name,['docente','coordinador','director','docente'])) {
            (new RepositoryCreator)->create($request->repository_name, $user, User::find($request->evaluator_id));
        }

        if($user->is_evaluator){
            $evaluator = new Evaluator();
            $evaluator->evaluator_id = $user->id;
            $evaluator->identifier = $user->identifier;
            $evaluator->educational_level = $request->educational_level;
            $evaluator->created_at = Carbon::now();
            $evaluator->updated_at = Carbon::now();

            $evaluator->save();
        }

        $user->syncAcademicUnits(
            $request->academic_unit_id ? AcademicUnit::where('id', $request->academic_unit_id)->get() : collect()
        );

        Mail::to($user->email)
            ->send(new UserRegisteredMail($user, $password));

        Alert::success('¡Usuario agregado!', 'El usuario ha sido añadido a la base de datos.');
        return redirect()->route('users.index');
    }
}
