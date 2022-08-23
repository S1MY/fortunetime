<?php

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

/* Freekassa */
Route::post('/freekassa', 'App\Http\Controllers\FreekassaController@freekassa')->name('freekassa');
Route::post('/freekassa/pay', 'App\Http\Controllers\FreekassaController@pay')->name('freekassa.pay')->middleware('auth');
Route::post('/freekassa/payed', 'App\Http\Controllers\FreekassaController@successful')->name('freekassa.payed');
Route::post('/freekassa/fail', 'App\Http\Controllers\FreekassaController@fail')->name('freekassa.fail');
