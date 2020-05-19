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

Route::get('/', 'PagesController@index');

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
Route::get('info/{id}', 'PagesController@infodetail')->name('infodetail');
Route::get('contact', 'PagesController@contact')->name('contact');
Route::post('contact/comfirm', 'PagesController@comfirm')->name('comfirm');
Route::post('contact/complete', 'PagesController@complete')->name('complete');

// 退会後表示
Route::get('afterwithdrawal', 'PagesController@afterwithdrawal')->name('afterwithdrawal');

// 受講券
Route::get('ticket_pdf/{id}','PagesController@ticket_pdf')->name('ticket_pdf');







// 全ユーザ
Route::group(['middleware' => ['auth', 'can:user-higher']], function () {

  Route::get('dashboard', 'HomeController@index')->name('dashboard');
  
  // インフォーメーション
  Route::resource('information', 'InformationController');

  // ユーザ詳細
  Route::get('account/{user_id}', 'UsersController@show')->name('account.show');

  // ユーザ編集
  Route::get('account/edit/{user_id}', 'UsersController@edit')->name('account.edit');
  Route::post('account/edit/{user_id}', 'UsersController@update')->name('account.post');

  // 研修
  // Route::get('event', 'EventsController@index')->name('event.index');
  // Route::get('event/{id}', 'EventsController@show')->name('event.show');
  // Route::post('event', 'EventsController@store')->name('event.store'); 
  // Route::put('event/{id}', 'EventsController@update')->name('event.update'); 
  // Route::delete('event/{id}', 'EventsController@destroy')->name('event.destroy');
  // Route::get('event/create', 'EventsController@create')->name('event.create'); 
  // Route::get('event/{id}/edit', 'EventsController@edit')->name('event.edit');
  Route::resource('event', 'EventsController');
  Route::get('event/list/before', 'EventsController@before')->name('event.before');
  Route::get('event/list/finished', 'EventsController@finished')->name('event.finished');
  Route::post('event/apply', 'EventsController@apply')->name('event.apply');
  Route::post('event/cancel', 'EventsController@cancel')->name('event.cancel'); 

  // 受講履歴
  Route::get('history', 'HistoryController@index')->name('history.index');
  Route::get('history/user/{user_id}', 'HistoryController@show')->name('history.show');
  // 受講証明書
  Route::get('attendance_pdf/{id}','HistoryController@attendance_pdf')->name('history.attendance_pdf');
  // 修了証
  Route::get('certificate_pdf/{id}','HistoryController@certificate_pdf')->name('history.certificate_pdf');

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

  // 履歴管理
  Route::get('history/user', 'HistoryController@user')->name('history.user');

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
  Route::get('entry/list/interm', 'EntryController@interm')->name('entry.interm');
  Route::get('entry/list/finished', 'EntryController@finished')->name('entry.finished');
  // 申込者一覧
  Route::get('entry/{id}', 'EntryController@show')->name('entry.show');
  // 受講券送信
  Route::post('entry/ticketsend', 'EntryController@ticketsend')->name('entry.ticketsend'); 
  // 受講キャンセル
  Route::post('entry/cancel', 'EntryController@cancel')->name('entry.cancel'); 
  // 受講データ削除
  Route::post('entry/destroy', 'EntryController@destroy')->name('entry.delete'); 
  // 申込者一覧CSV
  Route::post('entry/entry_csv', 'EntryController@entry_csv')->name('entry.entry_csv'); 

  // 受付管理index（開催間近の研修）
  Route::get('reception', 'ReceptionController@index')->name('reception.index');
  // 受付管理index（終了した研修）
  Route::get('reception/finished', 'ReceptionController@finished')->name('reception.finished');
  // 受付管理 - 申込者
  Route::get('reception/{id}', 'ReceptionController@show')->name('reception.show');
  // 受付管理 - 手動受付
  Route::post('reception/manual', 'ReceptionController@manual')->name('reception.manual');
  // 受付管理 - 申込者（バーコード読取専用）
  Route::get('reception/qr/{id}', 'ReceptionController@readqr')->name('reception.readqr');
  // 受付管理 - バーコード読取受付
  Route::post('reception/auto', 'ReceptionController@auto')->name('reception.auto');
  // 受付管理 - 受付者一覧CSV
  Route::post('reception/reception_csv', 'ReceptionController@reception_csv')->name('reception.reception_csv'); 

  // 修了証送信
  Route::post('history/certificatesend','HistoryController@certificatesend')->name('history.certificatesend');

});

// システム管理者のみ
Route::group(['middleware' => ['auth', 'can:system-only']], function () {

  // ユーザ一覧（支部）
  Route::get('account/branch/user', 'UsersController@branch_user')->name('account.branch_user');
  // ユーザ一覧（法人）
  Route::get('account/company/user', 'UsersController@company_user')->name('account.company_user');
  // ユーザ一覧（個人）
  Route::get('account/general/user', 'UsersController@general_user')->name('account.general_user');

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
  // csvダウンロード（権限別）
  Route::post('account/user_csv', 'UsersController@user_csv')->name('account.user_csv');


  // メール配信（送信済一覧、下書き）  
  Route::get('mail', 'EmailController@index')->name('mail.index');
  // メール配信（メール作成）
  Route::get('mail/create', 'EmailController@create')->name('mail.create');
  Route::post('mail', 'EmailController@store')->name('mail.store');
  // メール配信（メール詳細）
  Route::get('mail/{id}', 'EmailController@show')->name('mail.show');
  // メール配信（メール編集）
  Route::get('mail/{id}/edit', 'EmailController@edit')->name('mail.edit');
  Route::put('mail/{id}', 'EmailController@update')->name('mail.update'); 
  Route::delete('mail/{id}', 'EmailController@destroy')->name('mail.destroy');

  // メール配信（グループ設定一覧）
  Route::get('mailgroup', 'MailgroupController@index')->name('mailgroup.index');
  // メール配信（グループ作成）
  Route::get('mailgroup/create', 'MailgroupControllerp@create')->name('mailgroup.create');
  Route::post('mailgroup', 'MailgroupController@store')->name('mailgroup.store');
  // メール配信（グループ詳細）
  Route::get('mailgroup/{id}', 'MailgroupController@show')->name('mailgroup.show');
  // メール配信（メール編集）
  Route::get('mailgroup/{id}/edit', 'MailgroupController@edit')->name('mailgroup.edit');
  Route::put('mailgroup/{id}', 'MailgroupController@update')->name('mailgroup.update'); 
  Route::delete('mailgroup/{id}', 'MailgroupController@destroy')->name('mailgroup.destroy');


  // インフォーメーション
  //Route::resource('information', 'InformationController');
  // Route::get('information', 'InformationController@index')->name('information.index');
  // Route::get('information/{id}', 'InformationController@show')->name('information.show');
  // Route::get('information', 'InformationController@index')->name('information.index');
  // Route::post('information', 'InformationController@store')->name('information.store'); 
  // Route::put('information/{id}', 'InformationController@update')->name('information.update'); 
  // Route::delete('information/{id}', 'InformationController@destroy')->name('information.destroy');
  // Route::get('information/create', 'InformationController@create')->name('information.create'); 
  // Route::get('information/{id}/edit', 'InformationController@edit')->name('information.edit');

  // 問い合わせ
  Route::get('inquiry','ContactController@index')->name('inquiry.index');
  Route::get('inquiry/{id}','ContactController@show')->name('inquiry.show');
  
});