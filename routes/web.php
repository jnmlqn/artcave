<?php

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
Route::get('backend/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('backend/login', 'Auth\LoginController@login');
Route::post('backend/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('backend/forgot-password', 'Auth\LoginController@forgotPassword');
Route::post('backend/forgot-password', 'Auth\LoginController@sendForgotPassword');
Route::get('backend/reset/password/{token}', 'Auth\LoginController@resetPassword');
Route::post('backend/reset/password/{token}', 'Auth\LoginController@saveNewPassword');

Route::get('restricted', function() {
	return view('restricted');
});

Route::get('/', 'HomeController@index');
Route::get('about-us', 'HomeController@aboutUs');
Route::get('contact-us', 'HomeController@contactUs');
Route::get('the-cafe', 'HomeController@theCafe');
Route::get('the-gallery', 'HomeController@theGallery');
Route::get('media', 'HomeController@media');
Route::get('promos-and-events', 'HomeController@promosEvents');
Route::post('/media/inquire', 'HomeController@inquire');
Route::post('/contact-us/send', 'HomeController@sendMessage');

Route::post('subscribe', 'SubscribersController@subscribeNow');

Route::group(['middleware' => 'auth'], function() {
	Route::get('backend/dashboard', 'LogsController@index');

	Route::group(['middleware' => 'access:1,false'], function() {
		Route::resource('backend/users', 'UsersController', ['only' => 'index']);
		Route::resource('backend/artists', 'ArtistsController', ['only' => 'index']);
		Route::resource('backend/categories', 'CategoriesController', ['only' => 'index']);
		Route::resource('backend/menus', 'MenusController', ['only' => 'index']);
		Route::resource('backend/subscribers', 'SubscribersController', ['only' => 'index']);
	});

	Route::group(['middleware' => 'access:1,true'], function() {
		Route::resource('backend/users', 'UsersController', ['except' => 'index']);
		Route::resource('backend/artists', 'ArtistsController', ['except' => 'index']);
		Route::resource('backend/categories', 'CategoriesController', ['except' => 'index']);
		Route::resource('backend/menus', 'MenusController', ['except' => 'index']);
		Route::resource('backend/subscribers', 'SubscribersController', ['except' => 'index']);
		Route::get('search/artists', 'ArtistsController@searchIndex');
	});

	Route::resource('backend/art-pieces', 'ArtPiecesController');

	Route::resource('backend/promos-and-events', 'PromosController');

	Route::resource('backend/media', 'MediaController');

	Route::post('change-password', 'UsersController@changePassword');
});

// Route::get('test', function() {
// 	imagewebp(imagecreatefromjpeg('http://localhost:8081/assets/about-us/about1.jpg'), 'assets/about-us/about1-webp.jpg', 10);
// 	imagewebp(imagecreatefromjpeg('http://localhost:8081/assets/about-us/about2.jpg'), 'assets/about-us/about2-webp.jpg', 10);
// 	imagewebp(imagecreatefromjpeg('http://localhost:8081/assets/about-us/about3.jpg'), 'assets/about-us/about3-webp.jpg', 10);
// 	imagewebp(imagecreatefromjpeg('http://localhost:8081/assets/about-us/about4.jpg'), 'assets/about-us/about4-webp.jpg', 10);
// 	imagewebp(imagecreatefromjpeg('http://localhost:8081/assets/about-us/about5.jpg'), 'assets/about-us/about5-webp.jpg', 10);
// });