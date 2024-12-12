<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Crear permisos si no existen
        $permissions = [
            'create_tasks',
            'edit_tasks',
            'delete_tasks',
            'view_tasks',
            'create_users',
            'edit_users',
            'delete_users',
            'view_reports',
            'view_areas',
            'create_areas',
            'edit_areas',
            'delete_areas',
        ];

        foreach ($permissions as $permission) {
            // Crear el permiso para el guard 'web', asegurándose de que se cree solo una vez
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Obtener roles ya existentes, o crearlos si no existen
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $editor = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        $viewer = Role::firstOrCreate(['name' => 'viewer', 'guard_name' => 'web']);

        // Asignar permisos a roles

        // Permisos para el rol admin (todos los permisos incluidos los de áreas)
        $admin->syncPermissions([
            'create_tasks',
            'edit_tasks',
            'delete_tasks',
            'view_tasks',
            'create_users',
            'edit_users',
            'delete_users',
            'view_reports',
            'view_areas',
            'create_areas',
            'edit_areas',
            'delete_areas',
        ]);

        // Permisos para el rol editor
        $editor->syncPermissions([
            'create_tasks',
            'edit_tasks',
            'view_tasks',
            'view_reports',
        ]);

        // Permisos para el rol viewer
        $viewer->syncPermissions([
            'view_tasks',
            'view_reports',
        ]);
    }
}
