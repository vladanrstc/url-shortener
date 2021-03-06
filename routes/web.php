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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get("my-urls", [\App\Http\Controllers\UrlsController::class, "index"])->name("my_urls");
});

Route::resource("urls", \App\Http\Controllers\UrlsController::class);
Route::get("/g/{last_segment}", [\App\Http\Controllers\RedirectController::class, "redirect_to_url"]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
