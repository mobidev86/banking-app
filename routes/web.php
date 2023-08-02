<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\TransferController;
use Illuminate\Support\Facades\Auth;
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
Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/deposit', [DepositController::class, 'index'])->name('deposit');
    Route::post('/add-deposit', [DepositController::class, 'add'])->name('add-deposit');
    
    Route::get('/withdraw', [WithdrawController::class, 'index'])->name('withdraw');
    Route::post('/add-withdraw', [WithdrawController::class, 'add'])->name('add-withdraw');
    
    Route::get('/transfer', [TransferController::class, 'index'])->name('transfer');
    Route::get('/autocomplete-email', [TransferController::class, 'autocomplete'])->name('autocomplete.email');
    Route::post('/add-transfer', [TransferController::class, 'add'])->name('add-transfer');
    
    Route::get('/statement/{type?}', [HomeController::class, 'statement'])->name('statement');
    
    Route::get('/logout', [HomeController::class, 'logout'])->name('logout');

});