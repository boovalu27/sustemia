<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Area;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Asegura que el usuario esté autenticado
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        // Verificar si el usuario tiene el permiso 'view_reports'
        if (!$user->can('view_reports')) {
            return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta página.');
        }

        // Si tiene el permiso 'view_reports', mostramos el dashboard
        return $this->indexDashboard($request);
    }

    public function adminDashboard()
    {
        $users = User::all();
        $tasks = Task::with('area')->orderBy('created_at', 'desc')->get();
        $areas = Area::all();

        return view('dashboards.admin', compact('users', 'tasks', 'areas'));
    }

    public function indexDashboard(Request $request)
    {
        // Filtrado de tareas para el editor
        $tasks = Task::with('area');

        if ($request->filled('search')) {
            $tasks->where('title', 'like', "%{$request->search}%")
                   ->orWhere('description', 'like', "%{$request->search}%");
        }

        if ($request->filled('area')) {
            $tasks->where('area_id', $request->area);
        }

        if ($request->filled('month')) {
            $tasks->whereMonth('due_date', $request->month);
        }

        if ($request->filled('year')) {
            $tasks->whereYear('due_date', $request->year);
        }

        if ($request->filled('status')) {
            $tasks->where('status', $request->status);
        }

        $tasks = $tasks->orderBy('created_at', 'desc')->get();
        $areas = Area::all();

        return view('dashboards.index', compact('tasks', 'areas'));
    }

    public function reportsDashboard()
    {
        $user = Auth::user();

        // Verificar si el usuario tiene el permiso 'view_reports'
        if (!$user->can('view_reports')) {
            return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta página.');
        }

        // Obtener las tareas próximas a vencer (este mes)
        $upcomingTasks = Task::where('due_date', '>', now())
            ->where('due_date', '<=', now()->endOfMonth()) // Tareas que vencen este mes
            ->orderBy('due_date')
            ->get();

        // Obtener las tareas retrasadas que no están completadas
        $overdueTasks = Task::where('due_date', '<', now())
            ->where('status', '!=', 'Completada')
            ->get();

        // Obtener las tareas "completadas con retraso"
        $completedWithDelayTasks = Task::where('status', 'Completada con retraso')->get();

        // Calcular las tareas completadas en el mes
        $completedTasksThisMonth = Task::where('status', 'Completada')
            ->whereBetween('updated_at', [now()->startOfMonth(), now()])
            ->count();

        // Contar las tareas por área, con estado de completadas y pendientes
        $tasksByArea = Task::selectRaw('area_id,
                                        areas.name as area_name,
                                        count(*) as total,
                                        sum(case when status = "Completada" then 1 else 0 end) as completed,
                                        sum(case when status = "Pendiente" then 1 else 0 end) as pending,
                                        sum(case when status = "Completada con retraso" then 1 else 0 end) as completed_with_delay')
            ->join('areas', 'areas.id', '=', 'tasks.area_id')
            ->groupBy('area_id', 'areas.name')
            ->get();

        // Calcular los porcentajes de tareas por estado
        $totalTasksCount = Task::count(); // Total de tareas en general
        $completedTasksCount = Task::where('status', 'Completada')->count();
        $pendingTasksCount = Task::where('status', 'Pendiente')->count();
        $overdueTasksCount = $overdueTasks->count(); // Ya hemos obtenido las retrasadas
        $completedWithDelayCount = $completedWithDelayTasks->count(); // Tareas completadas con retraso

        // Asegurarse de no dividir por cero
        $completedPercentage = $totalTasksCount > 0 ? ($completedTasksCount / $totalTasksCount) * 100 : 0;
        $pendingPercentage = $totalTasksCount > 0 ? ($pendingTasksCount / $totalTasksCount) * 100 : 0;
        $overduePercentage = $totalTasksCount > 0 ? ($overdueTasksCount / $totalTasksCount) * 100 : 0;
        $completedWithDelayPercentage = $totalTasksCount > 0 ? ($completedWithDelayCount / $totalTasksCount) * 100 : 0;

        // Datos para el gráfico de tareas por estado
        $taskStatusData = [
            'Completadas' => $completedTasksCount,
            'Pendientes' => $pendingTasksCount,
            'Retrasadas' => $overdueTasksCount,
            'Completadas con Retraso' => $completedWithDelayCount, // Nueva categoría
        ];

        // Si es admin, contar usuarios, roles, tareas y áreas
        if ($user->hasRole('admin')) {
            $totalUsersCount = User::count();
            $totalRolesCount = \DB::table('roles')->count();
            $totalAreasCount = Area::count();

            // Contar los usuarios por rol, sin excluir al usuario actual
            $adminCount = User::whereHas('roles', function($query) {
                $query->where('name', 'admin');
            })->count();

            $editorCount = User::whereHas('roles', function($query) {
                $query->where('name', 'editor');
            })->count();

            $viewerCount = User::whereHas('roles', function($query) {
                $query->where('name', 'viewer');
            })->count();

            // Devolver la vista con todos los datos
            return view('dashboards.reports', compact(
                'upcomingTasks',
                'overdueTasks',
                'totalUsersCount',
                'adminCount',
                'editorCount',
                'viewerCount',
                'totalRolesCount',
                'totalTasksCount',
                'totalAreasCount',
                'taskStatusData',
                'completedTasksCount',
                'pendingTasksCount',
                'overdueTasksCount',
                'completedWithDelayCount',
                'completedPercentage',
                'pendingPercentage',
                'overduePercentage',
                'completedWithDelayPercentage',
                'tasksByArea',
                'completedTasksThisMonth'
            ));
        }

        // Para editor y viewer, solo devuelve las tareas
        return view('dashboards.reports', compact(
            'upcomingTasks',
            'overdueTasks',
            'taskStatusData',
            'completedTasksCount',
            'pendingTasksCount',
            'overdueTasksCount',
            'completedWithDelayCount',
            'completedPercentage',
            'pendingPercentage',
            'overduePercentage',
            'completedWithDelayPercentage',
            'tasksByArea',
            'completedTasksThisMonth',
            'totalTasksCount'
        ));
    }

}
