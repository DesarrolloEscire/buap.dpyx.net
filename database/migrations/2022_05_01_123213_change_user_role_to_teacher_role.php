<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeUserRoleToTeacherRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('mysql')->table('roles')
            ->where('name', 'usuario')
            ->update(['name' => 'docente']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection('mysql')->table('roles')
            ->where('name', 'docente')
            ->update(['name' => 'usuario']);
    }
}
