<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;

Route::get('/' , [UsuariosController::class, 'Index'])->name('index');

Route::get('/usuarios', [UsuariosController::class, 'Form_html'])->name('usuarios.formulario');
Route::post('/usuarios/Registrar', [UsuariosController::class, 'Registrar'])->name('usuarios.registrar');
Route::get('/usuarios/listar', [UsuariosController::class, 'Listar'])->name('usuarios.listar');
Route::put('/usuarios/actualizar/{id}', [UsuariosController::class, 'Actualizar'])->name('usuarios.actualizar');
Route::delete('/usuarios/Eliminar/{id}', [UsuariosController::class, 'Eliminar'])->name('usuarios.eliminar');

