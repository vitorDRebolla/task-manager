<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
  return Inertia::render('Home');
});

Route::resource('tasks', TaskController::class);
Route::put('/tasks/{task}/status', [TaskController::class, 'updateStatus']);
Route::post('/tasks/reorder', [TaskController::class, 'reorder']); 