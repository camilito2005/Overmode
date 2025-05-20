<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;


Route::get('/', [UsuariosController::class, 'index'])->name('index');
Route::get('/usuarios/formulario', [UsuariosController::class, 'Form_html'])->name('usuarios.formulario');
Route::get('/usuarios', [UsuariosController::class, 'Listar'])->name('usuarios.listar');
Route::post('/usuarios/registrar', [UsuariosController::class, 'Registrar'])->name('usuarios.registrar');
Route::put('/usuarios/actualizar/{id}', [UsuariosController::class, 'Actualizar'])->name('usuarios.actualizar');
Route::delete('/usuarios/eliminar/{id}', [UsuariosController::class, 'Eliminar'])->name('usuarios.eliminar');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
