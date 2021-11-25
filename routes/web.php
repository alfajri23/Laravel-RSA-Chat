<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Livewire\Chat;

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

Route::group(['middleware' => ['auth']], function(){
	Route::get('/user',[LoginController::class, 'show_user']);
	Route::get('/chat/{id}',Chat::class)->name('main-chat');
	Route::post('/send_image',[Chat::class,'store_image'])->name('store_image');
	Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});


