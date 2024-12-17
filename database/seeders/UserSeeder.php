<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles si no existen
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $viewerRole = Role::firstOrCreate(['name' => 'viewer']);

        // Crear permisos si no existen
        $permissions = [
            'create_tasks', 'edit_tasks', 'delete_tasks', 'view_tasks',
            'create_users', 'edit_users', 'delete_users', 'view_reports',
            'view_areas', 'create_areas', 'edit_areas', 'delete_areas'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear un usuario admin
        $admin = User::create([
            'name' => 'Gerardo',
            'surname' => 'Piñero',
            'email' => 'gerardop@sustemia.com.ar',
            'password' => Hash::make('password123'),
        ]);
        // Asignar el rol 'admin' y los permisos directamente
        $admin->assignRole($adminRole);
        $admin->givePermissionTo($permissions); // Asignamos todos los permisos al admin

        // Crear un usuario editor
        $editor = User::create([
            'name' => 'Sofia',
            'surname' => 'Parikh',
            'email' => 'sofiap@sustemia.com.ar',
            'password' => Hash::make('password123'),
        ]);
        // Asignar el rol 'editor' y los permisos
        $editor->assignRole($editorRole);
        $editor->givePermissionTo([
            'create_tasks', 'edit_tasks', 'view_tasks', 'view_reports'
        ]); // Asignar permisos específicos al editor

        // Crear un usuario visualizador
        $viewer = User::create([
            'name' => 'Francis',
            'surname' => 'Underwood',
            'email' => 'francisu@sustemia.com.ar',
            'password' => Hash::make('password123'),
        ]);
        // Asignar el rol 'viewer' y los permisos
        $viewer->assignRole($viewerRole);
        $viewer->givePermissionTo([
            'view_tasks', 'view_reports'
        ]); // Asignar permisos específicos al viewer
    }
}
