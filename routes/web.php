<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;

// Rutas para el controlador de inicio
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Rutas de Autenticación (solo para usuarios invitados)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticationController::class, 'login'])->name('auth.login');
    Route::post('/login', [AuthenticationController::class, 'processLogin'])->name('auth.login.process');
    // Ruta para mostrar el formulario de cambio de contraseña
    Route::get('password/change', [AuthenticationController::class, 'showChangePasswordForm'])->name('auth.password.change.form');
    // Ruta para procesar el cambio de contraseña
    Route::post('password/change', [AuthenticationController::class, 'changePassword'])->name('auth.password.change');
});

// Ruta para cerrar sesión (solo autenticados)
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('auth.logout');

// Rutas de perfil de usuario (solo autenticados)
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/view', [ProfileController::class, 'show'])->name('profile.view');
});

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Dashboard general
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboards.index');
    Route::get('/reports', [DashboardController::class, 'reportsDashboard'])->middleware('permission:view_reports')->name('reports.index');

    // Ruta para ver detalles de una tarea (accesible para cualquier usuario autenticado)
    Route::get('tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');

    // Rutas de administración para tareas
    Route::prefix('tasks')->name('tasks.')->middleware('permission:view_tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
    });
    Route::prefix('tasks')->name('tasks.')->middleware('permission:create_tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('create');
    Route::post('/', [TaskController::class, 'store'])->name('store');
});

// Rutas de administración de tareas (requiere el permiso de editar tareas)
Route::prefix('tasks')->name('tasks.')->middleware('permission:edit_tasks')->group(function () {
    Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('edit');
    Route::put('/{task}', [TaskController::class, 'update'])->name('update');
});

// Rutas de administración de tareas (requiere el permiso de eliminar tareas)
Route::prefix('tasks')->name('tasks.')->middleware('permission:delete_tasks')->group(function () {
    Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
});

});


Route::middleware(['auth'])->group(function () {

    // Dashboard de administrador
    Route::get('/settings', [AdminController::class, 'index'])->name('admin.index');

    // Rutas de administración de usuarios (solo accesibles para admin)
    Route::prefix('users')->name('users.')->middleware('permission:view_areas')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->middleware('permission:create_users')->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->middleware('permission:edit_users')->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->middleware('permission:delete_users')->name('destroy');
        Route::get('/{user}', [UserController::class, 'show'])->middleware('permission:view_users')->name('show');
        Route::post('/{user}/toggle', [UserController::class, 'toggleActive'])->name('toggle');
    });

    // Rutas de administración de áreas (solo accesibles para admin)
    Route::prefix('areas')->name('areas.')->group(function () {
        Route::get('/', [AreaController::class, 'index'])->middleware('permission:view_areas')->name('index');
        Route::get('/create', [AreaController::class, 'create'])->name('create');
        Route::post('/', [AreaController::class, 'store'])->name('store');
        Route::get('/{area}', [AreaController::class, 'show'])->middleware('permission:view_areas')->name('show');
        Route::get('/{area}/edit', [AreaController::class, 'edit'])->middleware('permission:edit_areas')->name('edit');
        Route::put('/{area}', [AreaController::class, 'update'])->name('update');
        Route::delete('/{area}', [AreaController::class, 'destroy'])->middleware('permission:delete_areas')->name('destroy');
    });
});
