<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    use HasFactory;

    const TEACHER_ROLE = "docente";
    const ADMINISTRATOR_ROLE = "administrador";
    const EVALUATOR_ROLE = "evaluador";
    const COORDINATOR_ROLE = "coordinador";
    const DIRECTOR_ROLE = "director";
    const SECRETARY_ROLE = "secretario";
}
