<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TareaController;

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



Route::post('/registro', [RegisterController::class, 'register']);

Route::post('/login', [RegisterController::class, 'login']);


