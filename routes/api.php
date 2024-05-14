<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\TagController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'tareas'], function () {
    Route::get('/', [TareaController::class, 'index']); // Listar tareas
    Route::post('/', [TareaController::class, 'store']); // Crear tarea
    Route::get('/{id}', [TareaController::class, 'show']); // Mostrar tarea específica
    Route::put('/{id}', [TareaController::class, 'update']); // Editar tarea
    Route::delete('/{id}', [TareaController::class, 'destroy']); // Eliminar tarea
});

Route::group(['prefix' => 'empresas'], function () {
    Route::get('/', [EmpresaController::class, 'index']);
    Route::post('/', [EmpresaController::class, 'store']);
    Route::get('/{id}', [EmpresaController::class, 'show']);
    Route::put('/{id}', [EmpresaController::class, 'update']);
    Route::delete('/{id}', [EmpresaController::class, 'destroy']);
});

Route::group(['prefix' => 'archivos'], function () {
    Route::get('/', [ArchivoController::class, 'index']); // Listar todos los archivos
    Route::post('/', [ArchivoController::class, 'store']); // Crear un nuevo archivo
    Route::get('/{id}', [ArchivoController::class, 'show']); // Mostrar un archivo específico por ID
    Route::put('/{id}', [ArchivoController::class, 'update']); // Actualizar un archivo existente
    Route::delete('/{id}', [ArchivoController::class, 'destroy']); // Eliminar un archivo
});

Route::group(['prefix' => 'tags'], function () {
    Route::get('/', [TagController::class, 'index']);
    Route::post('/', [TagController::class, 'store']);
    Route::get('/{id}', [TagController::class, 'show']);
    Route::put('/{id}', [TagController::class, 'update']);
    Route::delete('/{id}', [TagController::class, 'destroy']);
});

Route::post('/registro', [RegisterController::class, 'register']);

Route::post('/login', [RegisterController::class, 'login']);


