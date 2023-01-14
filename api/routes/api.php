<?php

use App\Entities\Account;
use Illuminate\Http\Request;
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
Route::get('/', function () {
  return 'ok';
});

Route::post('auth/login', 'AuthController@login')->name('login');
Route::post('auth/logout', 'AuthController@logout')->middleware('auth:sanctum');
Route::get('auth/user', 'AuthController@getUserByToken')->middleware('auth:sanctum');

Route::post('/users', 'UserController@create');

Route::prefix('accounts')->middleware('auth:sanctum', 'is_user')->group(function () {
  Route::get('balance/{user_id}', 'AccountController@show');
  Route::get('historic/{user_id}', 'AccountController@index');
  Route::post('{user_id}/transaction', 'AccountController@store');
});

Route::prefix('admin')->middleware('auth:sanctum', 'is_adm')->group(function () {
  Route::get('transactions', 'Admin\TransactionController@index');
  Route::post('transactions', 'Admin\TransactionController@update');
});


