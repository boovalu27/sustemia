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

        // Crear tareas de ejemplo solo si no existen previamente
        $this->createTaskIfNotExists($users->first()->id, 1, 'Revisar políticas de seguridad', 'Revisar y actualizar las políticas de seguridad de la empresa.', now()->addDays(2), 'Pendiente');

        if ($users->count() > 1) {
            $this->createTaskIfNotExists($users->skip(1)->first()->id, 2, 'Desarrollar nuevo módulo', 'Desarrollar un nuevo módulo para el sistema de gestión.', now()->addDays(14), 'Pendiente');
        }

        $this->createTaskIfNotExists($users->last()->id, 6, 'Plan de marketing', 'Crear un plan de marketing para el próximo trimestre.', now()->addDays(30), 'Completada', now()->addDays(30));

        // Nuevas tareas
        $this->createTaskIfNotExists($users->last()->id, 4, 'Comunicación de peligros y su prevención', '', now()->addDays(10), 'Pendiente');
        $this->createTaskIfNotExists($users->last()->id, 4, 'Programa on boarding SHE', '', now()->addDays(15), 'Pendiente');
        $this->createTaskIfNotExists($users->last()->id, 4, 'Actualización de matriz de entrenamiento por colaborador y puesto', '', now()->addDays(20), 'Pendiente');
        $this->createTaskIfNotExists($users->last()->id, 3, 'Prevención del dengue', '', now()->addDays(25), 'Pendiente');
        $this->createTaskIfNotExists($users->last()->id, 5, 'Día mundial del agua', '', now()->addDays(15), 'Pendiente');

        // Tarea vencida
        $this->createTaskIfNotExists($users->last()->id, 4, 'Comunicación de peligros y su prevención', 'Comunicación de peligros y su prevención.', now()->subDays(7), 'Completada con retraso', now()->subDays(2));

        $this->createTaskIfNotExists($users->last()->id, 6, 'Plan para el cumplimiento de acciones surgidas de accidentes', 'Medidas y procedimientos necesarios para dar respuesta eficaz a los accidentes ocurridos en el entorno laboral.', now()->addDays(30), 'Pendiente');
    }

    // Función para crear tareas si no existen
    private function createTaskIfNotExists($userId, $areaId, $title, $description, $dueDate, $status, $completedAt = null)
    {
        // Validar que la fecha de cierre no sea mayor a la fecha actual
        if ($completedAt && $completedAt > now()) {
            $completedAt = now();
        }

        // Usamos firstOrCreate para evitar duplicados
        Task::firstOrCreate([
            'user_id' => $userId,
            'area_id' => $areaId,
            'title' => $title,
            'due_date' => $dueDate,
        ], [
            'description' => $description,
            'status' => $status,
            'completed_at' => $completedAt,
        ]);
    }
}
