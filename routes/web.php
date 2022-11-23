<?php

use Illuminate\Routing\Route as RoutingRoute;
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

/* Pages */

Route::get('/', 'App\Http\Controllers\MainController@index')->name('main');

Route::get('/about', 'App\Http\Controllers\MainController@about')->name('about');

Route::get('/marketing', 'App\Http\Controllers\MainController@marketing')->name('marketing');

Route::get('/faq', 'App\Http\Controllers\MainController@faq')->name('faq');

Route::get('/reviews', 'App\Http\Controllers\MainController@reviews')->name('reviews');

Route::post('/reviews', 'App\Http\Controllers\ReviewsConroller@create')->name('createReview');

Route::get('/news', 'App\Http\Controllers\MainController@news')->name('news');

Route::get('/contacts', 'App\Http\Controllers\MainController@statistic')->name('statistic');

Route::post('/langchange', 'App\Http\Controllers\MainController@langchange')->name('lang');

/* Documents */

Route::get('/rules', 'App\Http\Controllers\MainController@rules')->name('rules');

Route::get('/personal', 'App\Http\Controllers\MainController@personal')->name('personal');

/* Mail Contacts */

Route::post('/send-mail', 'App\Http\Controllers\MailSendController@sendMailContact')->name('send');

/* Account  */

Auth::routes();

Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::get('/referral/{referral}', 'App\Http\Controllers\MainController@referral')->name('account');

Route::get('/account', 'App\Http\Controllers\MainController@account')->name('account')->middleware('auth');

Route::get('/start', 'App\Http\Controllers\MainController@start')->name('start')->middleware('auth');

Route::get('/automation', 'App\Http\Controllers\MainController@automation')->name('automation')->middleware('auth');

Route::get('/settings', 'App\Http\Controllers\MainController@settings')->name('settings')->middleware('auth');

Route::post('/settings/update-user/{id}', 'App\Http\Controllers\UserController@update')->name('update.user')->middleware('auth');

Route::post('/settings/update-user/personal/{id}', 'App\Http\Controllers\UserController@updatePersonalInfo')->name('update.personal')->middleware('auth');

Route::post('/settings/update-user/avatar/{id}', 'App\Http\Controllers\UserController@updateAvatar')->name('update.avatar')->middleware('auth');

Route::post('/user/{id}/{lvl}', 'App\Http\Controllers\UserController@getMatrix')->name('getmatrix')->middleware('auth');

/* Admin */

Route::get('/admin', 'App\Http\Controllers\AdminController@admin')->name('adminPage')->middleware('auth', 'is_admin');
Route::get('/admin/paied', 'App\Http\Controllers\AdminController@paied')->name('paied')->middleware('auth', 'is_admin');
Route::get('/admin/faq', 'App\Http\Controllers\AdminController@faq')->name('adminfaq')->middleware('auth', 'is_admin');
Route::get('/admin/reviews', 'App\Http\Controllers\AdminController@reviews')->name('adminreviews')->middleware('auth', 'is_admin');
Route::get('/admin/news', 'App\Http\Controllers\AdminController@news')->name('adminnews')->middleware('auth', 'is_admin');

Route::post('/admin/sorting', 'App\Http\Controllers\AdminController@adminSorting')->name('adminSorting')->middleware('auth', 'is_admin');
Route::post('/admin/add/faq', 'App\Http\Controllers\AdminController@adminAddFAQ')->name('adminAddFAQ')->middleware('auth', 'is_admin');
Route::post('/admin/delete/faq', 'App\Http\Controllers\AdminController@faqDelete')->name('faqDelete')->middleware('auth', 'is_admin');
Route::post('/admin/change/reviews', 'App\Http\Controllers\AdminController@reviewChanger')->name('reviewChanger')->middleware('auth', 'is_admin');
Route::post('/admin/sorting/reviews', 'App\Http\Controllers\AdminController@adminSortingRewiew')->name('adminSortingRewiew')->middleware('auth', 'is_admin');
Route::post('/admin/news/add', 'App\Http\Controllers\AdminController@adminAddNews')->name('adminAddNews')->middleware('auth', 'is_admin');
Route::post('/admin/delete/news', 'App\Http\Controllers\AdminController@newsDelete')->name('newsDelete')->middleware('auth', 'is_admin');
Route::post('/admin/users/change', 'App\Http\Controllers\AdminController@changeUserReferal')->name('changeUserReferal')->middleware('auth', 'is_admin');

Route::get('/account/matrix/{login}', 'App\Http\Controllers\AdminController@showMartix')->name('showMatrix')->middleware('auth', 'is_admin');

Route::post('/account/matrix/activation/', 'App\Http\Controllers\AdminController@activation')->name('activation')->middleware('auth', 'is_admin');


/* Freekassa */
Route::post('/freekassa', 'App\Http\Controllers\FreekassaController@freekassa')->name('freekassa');
Route::post('/freekassa/pay', 'App\Http\Controllers\FreekassaController@pay')->name('freekassa.pay')->middleware('auth');
Route::post('/freekassa/payed', 'App\Http\Controllers\FreekassaController@successful')->name('freekassa.payed');
Route::post('/freekassa/fail', 'App\Http\Controllers\FreekassaController@fail')->name('freekassa.fail');

/* Payeer */

Route::post('/payeer', 'App\Http\Controllers\PayeerController@payeer')->name('payeer')->middleware('auth');
Route::post('/payeer/pay', 'App\Http\Controllers\PayeerController@pay')->name('payeer.pay')->middleware('auth');
Route::get('/payeer/payed', 'App\Http\Controllers\PayeerController@payed')->name('payeer.payed');
Route::get('/payeer/fail', 'App\Http\Controllers\PayeerController@fail')->name('payeer.fail');


/* tester */

Route::get('/tester', 'App\Http\Controllers\AdminController@tester')->name('tester');

/* ADVCASH */
// Route::post('/advcash/pay', 'App\Http\Controllers\AdvController@pay')->name('adv.pay')->middleware('auth');
// Route::get('/advcash/payed', 'App\Http\Controllers\AdvController@payed')->name('adv.payed');
// Route::get('/advcash/fail', 'App\Http\Controllers\AdvController@fail')->name('adv.fail');
