<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;
use App\Models\Area;

class TaskSeeder extends Seeder
{
    public function run()
    {
        // Obtener usuarios y áreas existentes
        $users = User::all();
        $areas = Area::all();

        if ($users->isEmpty() || $areas->isEmpty()) {
            $this->command->info('No hay usuarios o áreas disponibles para asignar tareas.');
            return;
        }

        // Crear tareas de ejemplo
        Task::create([
            'user_id' => $users->first()->id,
            'area_id' => 1,
            'title' => 'Revisar políticas de seguridad',
            'description' => 'Revisar y actualizar las políticas de seguridad de la empresa.',
            'due_date' => now()->addDays(2),
            'status' => 'Pendiente',
        ]);

        if ($users->count() > 1) {
            Task::create([
                'user_id' => $users->skip(1)->first()->id,
                'area_id' => 2,
                'title' => 'Desarrollar nuevo módulo',
                'description' => 'Desarrollar un nuevo módulo para el sistema de gestión.',
                'due_date' => now()->addDays(14),
                'status' => 'Pendiente',
            ]);
        }

        Task::create([
            'user_id' => $users->last()->id,
            'area_id' => 6,
            'title' => 'Plan de marketing',
            'description' => 'Crear un plan de marketing para el próximo trimestre.',
            'due_date' => now()->addDays(30),
            'completed_at' => now()->addDays(30),
            'status' => 'Completada',
        ]);

        // Nuevas tareas
        Task::create([
            'user_id' => $users->last()->id,
            'area_id' => 4,
            'title' => 'Comunicación de peligros y su prevención',
            'description' => '',
            'due_date' => now()->addDays(10),
            'status' => 'Pendiente',
        ]);

        Task::create([
            'user_id' => $users->last()->id,
            'area_id' => 4,
            'title' => 'Programa on boarding SHE',
            'description' => '',
            'due_date' => now()->addDays(15),
            'status' => 'Pendiente',
        ]);

        Task::create([
            'user_id' => $users->last()->id,
            'area_id' => 4,
            'title' => 'Actualización de matriz de entrenamiento por colaborador y puesto',
            'description' => '',
            'due_date' => now()->addDays(20),
            'status' => 'Pendiente',
        ]);

        Task::create([
            'user_id' => $users->last()->id,
            'area_id' => 3,
            'title' => 'Prevención del dengue',
            'description' => '',
            'due_date' => now()->addDays(25),
            'status' => 'Pendiente',
        ]);

        Task::create([
            'user_id' => $users->last()->id,
            'area_id' => 5,
            'title' => 'Día mundial del agua',
            'description' => '',
            'due_date' => now()->addDays(15),
            'status' => 'Pendiente',
        ]);

        // Tarea vencida
        Task::create([
            'user_id' => $users->last()->id,
            'area_id' => 4,
            'title' => 'Comunicación de peligros y su prevención',
            'description' => 'Comunicación de peligros y su prevención.',
            'due_date' => now()->subDays(7),  // Fecha de vencimiento hace 7 días
            'completed_at' => now()->subDays(2),  // Fecha de cierre hace 2 días
            'status' => 'Completada con retraso',
        ]);

        Task::create([
            'user_id' => $users->last()->id,
            'area_id' => 6,
            'title' => 'Plan para el cumplimiento de acciones surgidas de accidentes',
            'description' => 'Medidas y procedimientos necesarios para dar respuesta eficaz a los accidentes ocurridos en el entorno laboral.',
            'due_date' => now()->addDays(30),
            'status' => 'Pendiente',
        ]);
    }
}
