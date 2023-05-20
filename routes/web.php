<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', [TaskController::class, 'homeTasks'])->middleware('auth')->name('home');

Route::get('/login', [AuthController::class, 'formLogin'])->name('auth.formLogin');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/register', [AuthController::class, 'formRegister'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');


Route::prefix('/blog')->name('blog.')->controller(BlogController::class)->group(function(){

    Route::get('/', 'index')->name('index'); 

     Route::get('/{slug}-{post}','show')->where([
    'post'=>'[0-9]+',
    'slug'=>'[a-z0-9\-]+'
    ])->name('show'); 

    Route::get('/new', 'create')->name('create')->middleware('auth');
    Route::post('/new', 'store')->name('store')->middleware('auth');

    Route::get('/{post}/edit', 'edit')->name('edit')->middleware('auth');
    Route::patch('/{post}/edit', 'update')->name('update')->middleware('auth');

    Route::get('/{categorie}/posts', 'articleCategorie')->name('articleCategorie');

});

Route::resource('/task', TaskController::class)->middleware('auth')->except(['show', 'create']);

Route::get('/task/create/{group?}', [TaskController::class, 'create'])->middleware('auth')->name('task.create');

Route::prefix('/task')->name('task.')->middleware('auth')->group(function(){

    Route::get('notifiable/{tache}', [TaskController::class, 'setNotifiableColumn'])->name('notifiable');
    Route::get('{id}/finish', [TaskController::class, 'marqueToFinish'])->name('marque.finish');
    Route::get('{id}/begin', [TaskController::class, 'marqueToBegin'])->name('marque.begin');
    Route::get('statistiques', [TaskController::class, 'statistiques'])->name('statistiques');  


    Route::get('terminees', [TaskController::class, 'tachesTerminees'])->name('terminees');
    Route::get('en_cours', [TaskController::class, 'tachesEncours'])->name('en_cours');
    Route::get('a_venir', [TaskController::class, 'tachesAVenir'])->name('a_venir');
    Route::get('terminees/retard', [TaskController::class, 'tasksTermineesRetard'])->name('retard');

});

Route::resource('/group', GroupController::class)->middleware('auth');

Route::prefix('/group')->name('group.')->middleware('auth')->group(function(){
    Route::get('workspace/{group}', [GroupController::class, 'workSpace'])->name('workspace');

    Route::get('invite/{group}/{user}', [GroupController::class, 'inviteUserToJoinGroup'])->name('invite.user');
    Route::get('accept/invitation/{group}/{user}', [GroupController::class, 'attachUserToGroup'])->name('attach.user');

    Route::get('{group}/{task}/assign', [GroupController::class, 'viewToAssignRolToUser'])->name('view.assign.rol');
    Route::post('tasks/assign/{task}', [GroupController::class, 'assinRolToUser'])->name('assign.rol');
    Route::get('tasks/assign/{task}/{user}', [GroupController::class, 'detachUserOnGroupTask'])->name('detach.rol');

    Route::get('{group}/tasks', [GroupController::class, 'groupTasks'])->name('tasks.index');
    Route::get('{group}/tasks_non_demarrees', [GroupController::class, 'tachesNonDemarrees'])->name('tasks.non.demarrees');
    Route::get('{group}/tasks_en_cours', [GroupController::class, 'tachesEnCours'])->name('tasks.en.cours');
    Route::get('{group}/tasks_terminees', [GroupController::class, 'tachesTerminees'])->name('tasks.terminees');
});

