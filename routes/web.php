<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\TodoController;

Route::get('/', function () {
    return redirect()->route('todos.index');
});

Route::resource('todos', TodoController::class)->except(['show']);
