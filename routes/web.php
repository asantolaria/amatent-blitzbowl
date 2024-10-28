<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\MatchdayController;
use App\Http\Controllers\GameController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

// Rutas de Liga (League)
Route::resource('leagues', LeagueController::class);

// Rutas de Equipos (Team)
Route::resource('teams', TeamController::class);

// Rutas de Entrenadores (Coach)
Route::resource('coaches', CoachController::class);

// Rutas de Jornadas (Matchday)
Route::resource('matchdays', MatchdayController::class);

// Rutas de Partidos (Game)
Route::resource('games', GameController::class);

Auth::routes();


Route::middleware('auth', 'alertas', 'user.disabled')->group(function () {
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');
    Route::get('/about', function () {
        return view('about');
    })->name('about');
});


# ADMIN - Administración de usuarios
Route::middleware('auth')->group(function () {
    Route::get('/admin/usuarios', [AdminUserController::class, 'index'])->name('admin.usuarios.index');
    Route::get('/admin/usuarios/create', [AdminUserController::class, 'create'])->name('admin.usuarios.create');
    Route::get('/admin/usuarios/{usuario}/edit', [AdminUserController::class, 'edit'])->name('admin.usuarios.edit');
    Route::get('/admin/usuarios/{usuario}', [AdminUserController::class, 'destroy'])->name('admin.usuarios.destroy');
    Route::get('/admin/usuarios/enable/{usuario}', [AdminUserController::class, 'enable'])->name('admin.usuarios.enable');
    Route::get('/admin/usuarios/disable/{usuario}', [AdminUserController::class, 'disable'])->name('admin.usuarios.disable');
    Route::post('/admin/usuarios', [AdminUserController::class, 'store'])->name('admin.usuarios.store');
    Route::put('/admin/usuarios/{usuario}', [AdminUserController::class, 'update'])->name('admin.usuarios.update');
    Route::get('/admin/usuarios/{usuario}/reset-password', [AdminUserController::class, 'resetPassword'])->name('admin.usuarios.reset-password');
});

# Rutas para el Gestor de Ligas de Blitzbowl
Route::middleware('auth')->group(function () {
    // Rutas de Liga (League)
    // Activar liga
    Route::get('/leagues/enable/{league}', [LeagueController::class, 'enable'])->name('leagues.enable');
    // Desactivar liga
    Route::get('/leagues/disable/{league}', [LeagueController::class, 'disable'])->name('leagues.disable');
    // Crear liga
    Route::post('/leagues/store', [LeagueController::class, 'store'])->name('leagues.store');
    // Editar liga
    Route::put('/leagues/{league}/update', [LeagueController::class, 'update'])->name('leagues.update');
    // Eliminar liga
    Route::get('/leagues/{league}/delete', [LeagueController::class, 'destroy'])->name('leagues.delete');

    // Rutas de Equipos (Team)
    // Crear equipo
    Route::post('/teams/store', [TeamController::class, 'store'])->name('teams.store');
    // Editar equipo
    Route::put('/teams/{team}/update', [TeamController::class, 'update'])->name('teams.update');
    // Eliminar equipo
    Route::get('/teams/{team}/delete', [TeamController::class, 'destroy'])->name('teams.delete');
});
