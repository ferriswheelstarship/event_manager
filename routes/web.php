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
// Auth::routes();

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// 仮ユーザ登録
Route::post('register/pre_check', 'Auth\RegisterController@preCheck')->name('register.pre_check');
// 本ユーザ登録
Route::get('register/verify/{token}', 'Auth\RegisterController@showForm');
Route::post('register/main_check', 'Auth\RegisterController@mainCheck')->name('register.main.check');
Route::post('register/main_register', 'Auth\RegisterController@mainRegister')->name('register.main.registered');

// 退会後表示
Route::get('afterwithdrawal', 'PagesController@afterwithdrawal')->name('afterwithdrawal');



// 全ユーザ
Route::group(['middleware' => ['auth', 'can:user-higher']], function () {

  Route::get('dashboard', 'HomeController@index')->name('dashboard');

  // ユーザ詳細
  Route::get('account/{user_id}', 'UsersController@show')->name('account.show');

  // ユーザ編集
  Route::get('account/edit/{user_id}', 'UsersController@edit')->name('account.edit');
  Route::post('account/edit/{user_id}', 'UsersController@update')->name('account.post');

});

// ユーザのみ
Route::group(['middleware' => ['auth', 'can:user-only']], function () {

  // 論理削除確認（休止）
  Route::get('account/withdrawal/confirm', 'UsersController@withdrawalconfirm')->name('account.withdrawalconfirm');
  // 論理削除（休止）
  Route::post('account/withdrawal/proceed', 'UsersController@withdrawal')->name('account.withdrawal');

});

// 施設権限以上
Route::group(['middleware' => ['auth', 'can:admin-higher']], function () {

  // ユーザ一覧
  Route::get('account', 'UsersController@index')->name('account.index');

});

// 施設権限のみ
Route::group(['middleware' => ['auth', 'can:admin-only']], function () {

  // 個人ユーザの所属解除
  Route::get('account/trimcompany/{user_id}', 'UsersController@trimcompany')->name('account.trimcompany');

});

// 支部ユーザ権限以上
Route::group(['middleware' => ['auth', 'can:area-higher']], function () {

  // Route::get('event', 'EventsController@index')->name('event.index');
  // Route::post('event', 'EventsController@store')->name('event.store'); 
  // Route::put('event/{id}', 'EventsController@update')->name('event.update'); 
  // Route::delete('event/{id}', 'EventsController@destroy')->name('event.destroy');
  // Route::get('event/create', 'EventsController@create')->name('event.create'); 
  // Route::get('event/{id}/edit', 'EventsController@edit')->name('event.edit');
  Route::resource('event', 'EventsController');

});

// システム管理者のみ
Route::group(['middleware' => ['auth', 'can:system-only']], function () {

  // ユーザ登録
  Route::get('account/regist/new', 'UsersController@regist')->name('account.regist');
  Route::post('account/regist/new', 'UsersController@firstPost')->name('account.firstPost');
  Route::get('account/regist/next', 'UsersController@registNext')->name('account.registNext');
  Route::post('account/regist/next', 'UsersController@create')->name('account.create');

  // 論理削除
  Route::delete('account/delete/{user_id}', 'UsersController@destroy')->name('account.softDelete');
  // 復元
  Route::post('account/restore/{user_id}', 'UsersController@restore')->name('account.restore');
  // 物理削除
  Route::delete('account/forceDelete/{user_id}', 'UsersController@forceDelete')->name('account.forceDelete');

});