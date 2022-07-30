<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Section;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        /**
         * =========
         * PERMISSIONS
         * =========
         */

        // create permissions for users
        Permission::firstOrCreate(['name' => 'index users']);
        Permission::firstOrCreate(['name' => 'create users']);
        Permission::firstOrCreate(['name' => 'edit users']);
        Permission::firstOrCreate(['name' => 'delete users']);

        // create permissions for categories
        Permission::firstOrCreate(['name' => 'index categories']);
        Permission::firstOrCreate(['name' => 'create categories']);
        Permission::firstOrCreate(['name' => 'edit categories']);
        Permission::firstOrCreate(['name' => 'delete categories']);

        // create permissions for subcategories
        Permission::firstOrCreate(['name' => 'index subcategories']);
        Permission::firstOrCreate(['name' => 'create subcategories']);
        Permission::firstOrCreate(['name' => 'edit subcategories']);
        Permission::firstOrCreate(['name' => 'delete subcategories']);

        // create permissions for questions
        Permission::firstOrCreate(['name' => 'index questions']);
        Permission::firstOrCreate(['name' => 'create questions']);
        Permission::firstOrCreate(['name' => 'edit questions']);
        Permission::firstOrCreate(['name' => 'delete questions']);

        // create permissions for answers
        Permission::firstOrCreate(['name' => 'create answers']);
        Permission::firstOrCreate(['name' => 'show answers']);

        // create permissions for observations
        Permission::firstOrCreate(['name' => 'create observations']);

        // create permissions for announcements
        Permission::firstOrCreate(['name' => 'index announcements']);
        Permission::firstOrCreate(['name' => 'create announcements']);
        Permission::firstOrCreate(['name' => 'edit announcements']);
        Permission::firstOrCreate(['name' => 'delete announcements']);

        // create permissions for repositories
        Permission::firstOrCreate(['name' => 'index repositories']);
        Permission::firstOrCreate(['name' => 'edit repositories']);
        Permission::firstOrCreate(['name' => 'show repositories']);

        // create permissions for evaluations
        Permission::firstOrCreate(['name' => 'index evaluations']);
        Permission::firstOrCreate(['name' => 'edit evaluations']);

        /**
         * ====
         * ROLES
         * ====
         */

        // create admin role
        $role = Role::firstOrCreate(['name' => Role::ADMINISTRATOR_ROLE]);
        $role->givePermissionTo(Permission::all());

        $role = Role::firstOrCreate(['name' => Role::TEACHER_ROLE]);

        $role = Role::firstOrCreate(['name' => Role::EVALUATOR_ROLE]);
        $role->givePermissionTo(['create announcements', 'edit announcements']);
        $role->givePermissionTo(['create observations']);
        $role->givePermissionTo(['edit evaluations']);
        $role->givePermissionTo(['index users']);
    }
}
