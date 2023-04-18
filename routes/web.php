<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'formLogin'])->name('auth.formLogin');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/register', [AuthController::class, 'formRegister'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');


route::prefix('/blog')->name('blog.')->controller(BlogController::class)->group(function(){

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