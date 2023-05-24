<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ExporteDataController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [TaskController::class, 'statistiques'])->middleware('auth')->name('home');

Route::get('/login', [AuthController::class, 'formLogin'])->name('auth.formLogin')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login')->middleware('guest');
Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');
Route::get('/register', [AuthController::class, 'register'])->name('auth.register')->middleware('guest');
Route::post('/register', [AuthController::class, 'doRegister'])->name('auth.doRegister')->middleware('guest');


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

Route::resource('/task', TaskController::class)->middleware('auth')->except(['show', 'create', 'edit']);
Route::get('/task/{task}/edit', [TaskController::class, 'edit'])->middleware('auth')->name('task.edit');

Route::get('/task/mynotifications', [HomeController::class, 'beginTaskNotification'])->middleware('auth')->name('task.group.mynotificaions');
Route::get('/task/mynotifications/{notification}/detail', [HomeController::class, 'notificationDetail'])->middleware('auth')->name('task.group.notification.detail');

Route::get('/task/create/{group?}', [TaskController::class, 'create'])->middleware('auth')->name('task.create');

Route::prefix('/task')->name('task.')->middleware('auth')->group(function(){

    Route::get('notifiable/{tache}', [TaskController::class, 'setNotifiableColumn'])->name('notifiable');
    Route::get('{task}/finish', [TaskController::class, 'marqueToFinish'])->name('marque.finish');
    Route::get('{task}/begin', [TaskController::class, 'marqueToBegin'])->name('marque.begin');
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
    Route::get('detach/user/{group}/detach', [GroupController::class, 'detachUserOnGroup'])->name('detach.user');

    Route::get('{group}/{task}/assign', [GroupController::class, 'viewToAssignRolToUser'])->name('view.assign.rol');
    Route::post('tasks/assign/{task}', [GroupController::class, 'assinRolToUser'])->name('assign.rol');
    Route::get('tasks/assign/{task}/{user}', [GroupController::class, 'detachUserOnGroupTask'])->name('detach.rol');
 

    Route::get('{group}/tasks', [GroupController::class, 'groupTasks'])->name('tasks.index');
    Route::get('{group}/tasks_non_demarrees', [GroupController::class, 'tachesNonDemarrees'])->name('tasks.non.demarrees');
    Route::get('{group}/tasks_en_cours', [GroupController::class, 'tachesEnCours'])->name('tasks.en.cours');
    Route::get('{group}/tasks_terminees', [GroupController::class, 'tachesTerminees'])->name('tasks.terminees');
    Route::get('{group}/task/terminees/retard', [GroupController::class, 'tachesTermineesEnRetard'])->name('tasks.terminees.retard');
    Route::get('{group}/tasks/user', [GroupController::class, 'myTasksInTheGroup'])->name('my.tasks');
    Route::get('explore/communities', [GroupController::class, 'groupsWhenImMember'])->name('im.member');


    Route::post('{group}/{task}/comment', [CommentController::class, 'store'])->name('task.comment.store');
});

Route::get('tasks/export/{task}/{type}', [ExporteDataController::class, 'export'])->middleware('auth')->name('tasks.export');