<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvitationsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::resource('projects.tasks', TasksController::class)
        ->only(['store', 'update']);

    Route::resource('projects', ProjectsController::class);

    Route::post('/projects/{project}/invitations', [InvitationsController::class, 'store']);
    Route::get('/', [HomeController::class, 'index'])->name('home');
});


