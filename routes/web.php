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


// webページ
Route::get('greeting', 'PagesController@greeting')->name('greeting');
Route::get('links', 'PagesController@links')->name('links');
Route::get('privacy', 'PagesController@privacy')->name('privacy');
Route::get('info', 'PagesController@info')->name('info');
Route::get('contact', 'PagesController@contact')->name('contact');

// 退会後表示
Route::get('afterwithdrawal', 'PagesController@afterwithdrawal')->name('afterwithdrawal');

// 受講券
Route::get('ticket_pdf/{id}','PagesController@ticket_pdf')->name('ticket_pdf');







// 全ユーザ
Route::group(['middleware' => ['auth', 'can:user-higher']], function () {

  Route::get('dashboard', 'HomeController@index')->name('dashboard');

  // ユーザ詳細
  Route::get('account/{user_id}', 'UsersController@show')->name('account.show');

  // ユーザ編集
  Route::get('account/edit/{user_id}', 'UsersController@edit')->name('account.edit');
  Route::post('account/edit/{user_id}', 'UsersController@update')->name('account.post');

  // 研修
  // Route::get('event', 'EventsController@index')->name('event.index');
  // Route::get('event/{id}', 'EventsController@show')->name('event.show');
  // Route::get('event', 'EventsController@index')->name('event.index');
  // Route::post('event', 'EventsController@store')->name('event.store'); 
  // Route::put('event/{id}', 'EventsController@update')->name('event.update'); 
  // Route::delete('event/{id}', 'EventsController@destroy')->name('event.destroy');
  // Route::get('event/create', 'EventsController@create')->name('event.create'); 
  // Route::get('event/{id}/edit', 'EventsController@edit')->name('event.edit');
  Route::resource('event', 'EventsController');
  Route::post('event/apply', 'EventsController@apply')->name('event.apply'); 
  Route::post('event/cancel', 'EventsController@cancel')->name('event.cancel'); 

});

// 個人ユーザのみ
Route::group(['middleware' => ['auth', 'can:user-only']], function () {

  // ユーザ論理削除確認（休止）
  Route::get('account/withdrawal/confirm', 'UsersController@withdrawalconfirm')->name('account.withdrawalconfirm');
  // ユーザ論理削除（休止）
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
  Route::put('account/trimcompany/{user_id}', 'UsersController@trimcompany')->name('account.trimcompany');

});

// 支部ユーザ権限以上
Route::group(['middleware' => ['auth', 'can:area-higher']], function () {

  // 研修復元
  Route::post('event/restore/{id}', 'EventsController@restore')->name('event.restore');
  // 研修物理削除
  Route::delete('event/forceDelete/{id}', 'EventsController@forceDelete')->name('event.forceDelete');
  // 研修アップロードファイル削除
  Route::delete('event/filedelete/{id}', 'EventsController@fileDelete')->name('event.fileDelete');

  // 申込者確認用index
  Route::get('entry', 'EntryController@index')->name('entry.index');
  // 申込者一覧
  Route::get('entry/{id}', 'EntryController@show')->name('entry.show');
  // 受講券送信
  Route::post('entry/ticketsend', 'EntryController@ticketsend')->name('entry.ticketsend'); 
  // 受講キャンセル
  Route::post('entry/cancel', 'EntryController@cancel')->name('entry.cancel'); 
  // 受講データ削除
  Route::post('entry/destroy', 'EntryController@destroy')->name('entry.delete'); 

});

// システム管理者のみ
Route::group(['middleware' => ['auth', 'can:system-only']], function () {

  // ユーザ登録
  Route::get('account/regist/new', 'UsersController@regist')->name('account.regist');
  Route::post('account/regist/new', 'UsersController@firstPost')->name('account.firstPost');
  Route::get('account/regist/next', 'UsersController@registNext')->name('account.registNext');
  Route::post('account/regist/next', 'UsersController@create')->name('account.create');

  // ユーザ論理削除
  Route::delete('account/delete/{user_id}', 'UsersController@destroy')->name('account.softDelete');
  // ユーザ復元
  Route::post('account/restore/{user_id}', 'UsersController@restore')->name('account.restore');
  // ユーザ物理削除
  Route::delete('account/forceDelete/{user_id}', 'UsersController@forceDelete')->name('account.forceDelete');

});