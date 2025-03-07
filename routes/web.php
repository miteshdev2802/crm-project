<?php

use App\Http\Controllers\ContactController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('contacts/', [ContactController::class, 'index'])->name('contacts.index')->middleware('auth');
Route::get('/contacts/list', [ContactController::class, 'list'])->name('contacts.list');
Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create')->middleware('auth');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store')->middleware('auth');
Route::get('/contacts/{id}/edit', [ContactController::class, 'edit'])->name('contacts.edit')->middleware('auth');
Route::put('/contacts/{id}', [ContactController::class, 'update'])->name('contacts.update')->middleware('auth');
Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy')->middleware('auth');
Route::post('/contacts/showcontacts', [ContactController::class, 'showMultipleContact'])->name('contacts.showcontacts')->middleware('auth');
Route::post('/contacts/mergecontacts', [ContactController::class, 'mergeContact'])->name('contacts.mergecontacts')->middleware('auth');
