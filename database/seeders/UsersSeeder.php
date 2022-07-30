<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::updateOrCreate([
            'email' => 'cguzman@ibsaweb.com',
        ], [
            'name' => 'Cristian',
            'identifier' => 'NSS000000',
            'phone' => '5512328187',
            'password' => bcrypt('¡MyP4ssw0rd!')
        ]);

        $user->assignRole(Role::ADMINISTRATOR_ROLE);

        $user = User::updateOrCreate([
            'email' => 'ovilla@ibsaweb.com',
        ], [
            'name' => 'Omar',
            'identifier' => 'NSS000001',
            'phone' => null,
            'password' => bcrypt('Pruebas123')
        ])->assignRole(Role::ADMINISTRATOR_ROLE);

        $userAdmin = User::updateOrCreate([
            'email' => 'nlopez@escire.mx'
        ], [
            'name' => 'Nydia Lopez',
            'identifier' => 'NSS000002',
            'phone' => null,
            'password' => bcrypt('1Aprender3948.')
        ])->assignRole(Role::ADMINISTRATOR_ROLE);

        if (config('app.is_evaluable')) {
            $userEvaluator = User::updateOrCreate([
                'email' => 'valni.info@gmail.com',
            ], [
                'identifier' => 'NSS000003',
                'name' => 'Nydia Evaluador',
                'phone' => null,
                'password' => bcrypt('1Aprender3948.')
            ])->assignRole('evaluador');
        }

        $user = User::updateOrCreate([
            'email' => 'vallei__oswal@hotmail.com',
        ], [
            'identifier' => 'NSS000004',
            'name' => 'Nydia Repositorio',
            'phone' => null,
            'password' => bcrypt('1Aprender3948.')
        ])->assignRole(Role::TEACHER_ROLE);

        User::updateOrCreate([
            'email' => 'paola.hernandez@correo.buap.mx',
        ], [
            'identifier' => '100500144',
            'name' => 'Paola Hernández Romero',
            'password' => bcrypt('p40l4h3rn4nd3z'),
            'email_verified_at' => Carbon::now()
        ])->assignRole(Role::ADMINISTRATOR_ROLE);

        User::firstOrCreate([
            'email' => 'korina.gutierrez@correo.buap.mx',
        ], [
            'identifier' => '100503111',
            'name' => 'Korina Gutiérrez Ramírez',
            'password' => bcrypt('k0r1n4gut13rr3z'),
            'email_verified_at' => Carbon::now()
        ])->assignRole(Role::ADMINISTRATOR_ROLE);

        User::firstOrCreate([
            'email' => 'emilio.soto@correo.buap.mx',
        ], [
            'identifier' => '100503411',
            'name' => 'Emilio Miguel Soto García',
            'password' => bcrypt('#13Bungee'),
            'email_verified_at' => Carbon::now()
        ])->assignRole(Role::ADMINISTRATOR_ROLE);

        User::firstOrCreate([
            'email' => 'segurajaramilloepsom@correo.buap.mx',
        ], [
            'identifier' => 'NSS101010',
            'name' => 'Epsom Enrique Segura Jaramillo',
            'password' => bcrypt('3nNsqNSY'),
            'email_verified_at' => Carbon::now()
        ])->assignRole(Role::ADMINISTRATOR_ROLE);
    }
}
