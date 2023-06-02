<?php

use Illuminate\Support\Facades\Route;

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

Route::resource('/notes', App\Http\Controllers\NoteController::class);

Route::get('/api/notes', [App\Http\Controllers\NoteController::class, 'api']);

Route::get('/', function () {
    return redirect('/notes');
});

