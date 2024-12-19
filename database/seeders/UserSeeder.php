<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
  /**
   * Ejecuta la siembra de los datos de usuarios y roles.
   *
   * Este seeder crea roles y permisos si no existen, y luego crea varios usuarios
   * con roles específicos y permisos asignados.
   *
   * @return void
   */
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

    // Crear permisos utilizando un ciclo para verificar si ya existen
    foreach ($permissions as $permission) {
      Permission::firstOrCreate(['name' => $permission]);
    }

    // Crear el usuario admin si no existe
    $admin = User::firstOrCreate(
      ['email' => 'gerardop@sustemia.com.ar'], // Verifica si el email ya existe
      [
        'name' => 'Gerardo',
        'surname' => 'Piñero',
        'password' => Hash::make('password123'),
      ]
    );
    // Asignar el rol 'admin' y todos los permisos al admin
    $admin->assignRole($adminRole);
    $admin->givePermissionTo($permissions);

    // Crear el usuario editor si no existe
    $editor = User::firstOrCreate(
      ['email' => 'sofiap@sustemia.com.ar'], // Verifica si el email ya existe
      [
        'name' => 'Sofia',
        'surname' => 'Parikh',
        'password' => Hash::make('password123'),
      ]
    );
    // Asignar el rol 'editor' y permisos específicos al editor
    $editor->assignRole($editorRole);
    $editor->givePermissionTo([
      'create_tasks', 'edit_tasks', 'view_tasks', 'view_reports'
    ]);

    // Crear un usuario visualizador si no existe
    $viewer = User::firstOrCreate(
      ['email' => 'francisu@sustemia.com.ar'], // Verifica si el email ya existe
      [
        'name' => 'Francis',
        'surname' => 'Underwood',
        'password' => Hash::make('password123'),
      ]
    );
    // Asignar el rol 'viewer' y permisos específicos al viewer
    $viewer->assignRole($viewerRole);
    $viewer->givePermissionTo([
      'view_tasks', 'view_reports'
    ]);

    // Crear un usuario admin si no existe (Cecilia Feijoo)
    $cecilia = User::firstOrCreate(
      ['email' => 'cecilia.feijoo@davinci.edu.ar'], // Verifica si el email ya existe
      [
        'name' => 'Cecilia',
        'surname' => 'Feijoo',
        'password' => Hash::make('password123'),
      ]
    );
    // Asignar el rol 'admin' y todos los permisos al admin
    $cecilia->assignRole($adminRole);
    $cecilia->givePermissionTo($permissions);

    // Crear un usuario admin si no existe (Carina Carballido)
    $carina = User::firstOrCreate(
      ['email' => 'carina.carballido@davinci.edu.ar'], // Verifica si el email ya existe
      [
        'name' => 'Carina',
        'surname' => 'Carballido',
        'password' => Hash::make('password123'),
      ]
    );
    // Asignar el rol 'admin' y todos los permisos al admin
    $carina->assignRole($adminRole);
    $carina->givePermissionTo($permissions);
  }
}
