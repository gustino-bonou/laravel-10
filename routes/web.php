<?php

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

route::prefix('/blog')->name('blog.')->controller(BlogController::class)->group(function(){

    Route::get('/', 'index')->name('index'); 

     Route::get('/{slug}-{post}','show')->where([
    'post'=>'[0-9]+',
    'slug'=>'[a-z0-9\-]+'
    ])->name('show'); 

    Route::get('/new', 'create')->name('create');
    Route::post('/new', 'store')->name('store');

    Route::get('/{post}/edit', 'edit')->name('edit');
    Route::patch('/{post}/edit', 'update')->name('update');

});