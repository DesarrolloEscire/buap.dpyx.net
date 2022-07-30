<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\AcademicUnit;
use App\Models\Evaluator;
use App\Models\User;
use App\Src\Repositories\Application\RepositoryCreator;
use App\Src\Users\Application\SyncAcademicUnits;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UpdateUserController extends Controller
{
    public function __invoke(UpdateUserRequest $request, User $user)
    {
        if (User::whereNotUser($user)->whereIdentifier($request->identifier)->exists()) {
            Alert::error("El identificador $request->identifier proporcionado ya existe en la base de datos");
            return redirect()->back();
        }

        if ($request->change_password == 'on') {

            if (!Hash::check($request->current_password, $user->password)) {
                Alert::warning('La contraseña actual no coincide');
                return redirect()->back();
            }

            if ($request->new_password != $request->new_password_repeated) {
                Alert::warning('La contraseña nueva no coincide.');
                return redirect()->back();
            }

            $user->password = bcrypt($request->new_password);
        }

        $user->name = strtoupper($request->name);
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->identifier = $request->identifier;
        $user->save();

        $user->syncRoles($request->role);

        $userUseRepository = $user->hasRole('docente') || $user->hasRole('coordinador') || $user->hasRole('director') || $user->hasRole('secretario');

        if ($userUseRepository && !$user->repositories()->exists()) {
            (new RepositoryCreator)->create(
                $request->repository_name,
                $user,
                User::find($request->evaluator_id),
            );
        }

        if ($userUseRepository && $user->has_repositories) {
            $user->repositories()->first()->update([
                'name' => $request->repository_name,
                'responsible_id' => $user->id
            ]);


            $user->repositories()->first()->evaluation()->update([
                'evaluator_id' => $request->evaluator_id
            ]);
        }

        if($user->is_evaluator){
            $evaluator = $user->evaluator()->exists() ? $user->evaluator()->exists() : new Evaluator();
            $evaluator->evaluator_id = $user->id;
            $evaluator->identifier = $user->identifier;
            $evaluator->educational_level = $request->educational_level;
            if($user->evaluator()->exists()){
                $evaluator->created_at = Carbon::now();
            }
            $evaluator->updated_at = Carbon::now();

            $evaluator->save();
        }

        $user->syncAcademicUnits(
            $request->academic_unit_id ? AcademicUnit::where('id',$request->academic_unit_id)->get() : collect()
        );

        Alert::success('¡Usuario modificado!');
        return redirect()->route('users.index');
    }
}
