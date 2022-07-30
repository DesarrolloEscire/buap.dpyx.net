<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeAdminRoleToAdministratorRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('mysql')->table('roles')
            ->where('name', 'admin')
            ->update(['name' => 'administrador']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection('mysql')->table('roles')
            ->where('name', 'administrador')
            ->update(['name' => 'admin']);
    }
}
