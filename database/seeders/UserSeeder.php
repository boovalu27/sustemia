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
            'role_id' => $adminRole->id,  // Asignar rol 'admin' directamente en la columna role_id
        ]);
        // Asignar el rol 'admin' y permisos
        $admin->assignRole($adminRole);
        $admin->syncPermissions($permissions);

        // Crear un usuario editor
        $editor = User::create([
            'name' => 'Sofia',
            'surname' => 'Parikh',
            'email' => 'sofiap@sustemia.com.ar',
            'password' => Hash::make('password123'),
            'role_id' => $editorRole->id,  // Asignar rol 'editor' directamente en la columna role_id
        ]);
        // Asignar el rol 'editor' y permisos
        $editor->assignRole($editorRole);
        $editor->syncPermissions([
            'create_tasks',
            'edit_tasks',
            'view_tasks',
            'view_reports',
        ]);

        // Crear un usuario visualizador
        $viewer = User::create([
            'name' => 'Francis',
            'surname' => 'Underwood',
            'email' => 'francisu@sustemia.com.ar',
            'password' => Hash::make('password123'),
            'role_id' => $viewerRole->id,  // Asignar rol 'viewer' directamente en la columna role_id
        ]);
        // Asignar el rol 'viewer' y permisos
        $viewer->assignRole($viewerRole);
        $viewer->syncPermissions([
            'view_tasks',
            'view_reports',
        ]);
    }
}
