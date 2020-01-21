<?php

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

// make:auth利用
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

// 仮ユーザ登録
Route::post('register/pre_check', 'Auth\RegisterController@preCheck')->name('register.pre_check');
// 本ユーザ登録
Route::get('register/verify/{token}', 'Auth\RegisterController@showForm');
Route::post('register/main_check', 'Auth\RegisterController@mainCheck')->name('register.main.check');
Route::post('register/main_register', 'Auth\RegisterController@mainRegister')->name('register.main.registered');


// 全ユーザ
Route::group(['middleware' => ['auth', 'can:user-higher']], function () {
  // ユーザ編集
  Route::get('/account/edit/{user_id}', 'UsersController@edit')->name('account.edit');
  Route::post('/account/edit/{user_id}', 'UsersController@updateData')->name('account.edit');

  // ユーザ削除
  Route::post('/account/delete/{user_id}', 'UsersController@delete');
});

// 管理者以上
Route::group(['middleware' => ['auth', 'can:admin-higher']], function () {
  // ユーザ登録
  Route::get('/account/regist', 'UsersController@regist')->name('account.regist');
  Route::post('/account/regist', 'UsersController@createData')->name('account.regist');

});

// システム管理者のみ
Route::group(['middleware' => ['auth', 'can:system-only']], function () {

});