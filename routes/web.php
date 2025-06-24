<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\CarritoControllers;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\TallasController;
use App\Http\Controllers\ColoresController;

use Illuminate\Support\Facades\Route;

Route::get('/', [UsuariosController::class, 'index'])->name('index');
Route::get('/usuarios/formulario', [UsuariosController::class, 'Form_html'])->name('usuarios.formulario');
Route::post('/usuarios/registrar', [UsuariosController::class, 'Registrar'])->name('usuarios.registrar');

Route::get('/Catalogo', [CatalogoController::class, 'Catalogo'])->name('catalogo');
Route::get('/catalogo/filtrar', [CatalogoController::class, 'Filtrar'])->name('catalogo.filtrar');
Route::get('/Catalogo/Detalles/{id}', [CatalogoController::class, 'Detalles'])->name('productos.detalles');
Route::get('/Catalogo/Buscar', [CatalogoController::class, 'Buscar'])->name('catalogo.buscar');

Route::post('/Carrito/Agregar', [CarritoControllers::class, 'AggCarrito'])->name('carrito.agregar');
Route::get('/Carrito/Ver', [CarritoControllers::class, 'VerCarrito'])->name('carrito.ver');
Route::post('/Carrito/Actualizar', [CarritoControllers::class, 'ActualizarCarrito'])->name('carrito.actualizar');
Route::delete('/Carrito/Eliminar/{id}', [CarritoControllers::class, 'EliminarItem'])->name('carrito.eliminar');
Route::get('/Carrito/Vaciar', [CarritoControllers::class, 'VaciarCarrito'])->name('carrito.vaciar');


Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/usuarios', [UsuariosController::class, 'Listar'])->name('usuarios.listar');
    Route::put('/usuarios/actualizar/{id}', [UsuariosController::class, 'Actualizar'])->name('usuarios.actualizar');
    Route::delete('/usuarios/eliminar/{id}', [UsuariosController::class, 'Eliminar'])->name('usuarios.eliminar');

    Route::get('/productos/formulario', [ProductosController::class, 'Formulario'])->name('productos.formulario');
    Route::post('/productos/guardar', [ProductosController::class, 'Guardar'])->name('productos.guardar');
    Route::get('/productos/ver', [ProductosController::class, 'Listar'])->name('productos.listar');
    Route::get('/productos/modificar/{id}', [ProductosController::class, 'Form_editar'])->name('productos.editar');
    Route::put('/productos/actualizar/{id}', [ProductosController::class, 'Actualizar'])->name('productos.actualizar');
    Route::post('/productos/eliminar/{id}', [ProductosController::class, 'Eliminar'])->name('productos.eliminar');


    Route::get('/productos/combinaciones', [ProductosController::class, 'Combinaciones'])->name('productos.combinaciones');


    Route::post('/Catalogo/Opinion/{id}', [CatalogoController::class, 'Opinion'])->name('catalogo.opinion');

    Route::post('/categorias/guardar', [CategoriasController::class, 'guardar'])->name('categorias.agregar');
    Route::put('/categorias/Actualizar/{id}', [CategoriasController::class, 'Actualizar'])->name('categorias.Actualizar');
    Route::delete('/categorias/eliminar/{id}', [CategoriasController::class, 'Eliminar'])->name('categorias.eliminar');

    Route::post('/Tallas/agregar', [TallasController::class, 'Agregar'])->name('Tallas.agregar');
    Route::put('/Tallas/Actualizar/{id}', [TallasController::class, 'Actualizar'])->name('tallas.actualizar');
    Route::delete('/Tallas/Eliminar/{id}', [TallasController::class, 'Eliminar'])->name('tallas.eliminar');

    Route::post('/colores/agregar', [ColoresController::class, 'Agregar'])->name('colores.agregar');
    Route::put('/colores/Actualizar/{id}', [ColoresController::class, 'Actualizar'])->name('colores.actualizar');
    Route::delete('/colores/Eliminar/{id}', [ColoresController::class, 'Eliminar'])->name('colores.eliminar');

    Route::post('/sincronizar-carrito' , [CarritoControllers::class, 'Sincronizar'])->name('sincronizar');
});

require __DIR__ . '/auth.php';
