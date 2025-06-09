<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('login');
});

Auth::routes([
    // "register" => false,
]);

Route::get('/home', [App\Http\Controllers\ApplicationController::class, 'index'])->name('home');
Route::resource('application', App\Http\Controllers\ApplicationController::class);
Route::resource('application_details', App\Http\Controllers\ApplicationDetailController::class);
Route::get('/download/{id}', [App\Http\Controllers\ApplicationDetailController::class, 'download'])->name('download');
Route::get('/public/{id}/show', [App\Http\Controllers\HomeController::class, 'show'])->name('public_show');
Route::get('/public/{id}/download', [App\Http\Controllers\HomeController::class, 'download'])->name('public_download');
Route::post('/shorten', [App\Http\Controllers\ShortUrlController::class, 'store'])->name('shorten.url');
Route::get('/{shortCode}', [App\Http\Controllers\ShortUrlController::class, 'redirect'])->name('redirect');
