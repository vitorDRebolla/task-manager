<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
  return Inertia::render('Home');
});

Route::resource('tasks', TaskController::class);