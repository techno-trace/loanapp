<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [App\Http\Controllers\API\AuthenticationManager::class, 'register'])->name('register');

Route::post('/login', [App\Http\Controllers\API\AuthenticationManager::class, 'login'])->name('login');

Route::post('/logout', [App\Http\Controllers\API\AuthenticationManager::class, 'logout'])->name('logout');

Route::resource('/loans', App\Http\Controllers\API\LoansController::class)

->only(['index', 'show'])

->names([
    'index' => 'loans',
    'show' => 'loans.show',
]);

Route::get('/user/loans', [App\Http\Controllers\API\LoansController::class, 'userLoans'])->name('user.loans');

Route::match(['POST'], '/loans/{loan}/request', [App\Http\Controllers\API\LoanRequestsController::class, 'request'])

->name('loan.request');

Route::match(['PUT', 'PATCH'], '/loans/{loan}/request/{request}', [App\Http\Controllers\API\LoanRequestsController::class, 'update'])

->name('loan.request.update');

Route::post('/loans/{loan_request}/repay', [App\Http\Controllers\API\LoanRepaymentsController::class, 'repay'])->name('loan.repay');
