<?php

use App\Http\Controllers\GruposController;
use App\Http\Controllers\MateriasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(RoleMiddleware::class . ':admin')->group(function () {
    Route::get('/user/add', [UserController::class, 'create'])->name('users.add');
    Route::get('/user/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/user/delete', [UserController::class, 'delete'])->name('user.delete');
    Route::patch('/user/edit', [UserController::class, 'update'])->name('user.update');
    /*   <---------Materias---------> */
    Route::get('materias', [MateriasController::class, 'index'])->name('materias.index');
    Route::get('materias/add', [MateriasController::class, 'addMaterias'])->name('materias.add');
    Route::post('materias', [MateriasController::class, 'store'])->name('materias.register');
    Route::get('materias/{id}', [MateriasController::class, 'edit'])->name('materias.edit');
    Route::patch('materias/edit', [MateriasController::class, 'update'])->name('materias.update');
    Route::delete('materias/delete', [MateriasController::class, 'delete'])->name('materias.delete');
    /*  <---------Grupos------------->  */
    Route::get('grupos/add', [GruposController::class, 'addMaterias'])->name('grupos.add');
    Route::post('grupos', [GruposController::class, 'store'])->name('grupos.register');
    Route::get('grupos/{id}/activate', [GruposController::class, 'activate'])->name('grupos.activate');
    Route::get('grupos/{id}', [GruposController::class, 'edit'])->name('grupos.edit');
    Route::patch('grupos/edit', [GruposController::class, 'update'])->name('grupos.update');
    Route::delete('grupos/delete', [GruposController::class, 'delete'])->name('grupos.delete');
});

Route::middleware(RoleMiddleware::class . ':admin,profesor')->group(function () {
    Route::get('grupos', [GruposController::class, 'index'])->name('grupos.index');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/', function () {
        return view('home');
    })->name('home');
});

require __DIR__ . '/auth.php';
