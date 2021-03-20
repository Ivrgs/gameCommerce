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


Auth::routes();
Auth::routes(['verify' => true]);
// Route::post('/Verify', 'Auth\RegisterController@create')->name("Verify.Account");

Route::get('/home', 'HomeController@index')->name('Home Controller');
Route::post('/updateAccount/{id}', 'HomeController@updatePassword')->name('User Password');
Route::get('/mail', 'ShopController@sendEmail');
Route::get('/reviewItem', 'ReviewController@index')->name('Review.Controller');


Route::get('/', 'ShopController@index')->name('ShopController');
Route::get('/viewItem/{ItemId}', 'ShopController@show')->name('ShopViewItem');
Route::post('/addtocart', 'ShopController@store')->name('ShopAddCart');
Route::get('/viewCart/{id}', 'ShopController@showcart')->name('ShopViewCart');
Route::post('/deletecart/{id}', 'ShopController@deletecart')->name('ShopDeleteCart');
Route::post('/checkout', 'ShopController@checkout')->name('ShopCheckout');
Route::post('/wishlist', 'ShopController@wishstore')->name('ShopWishlist');
Route::post('/removewish', 'ShopController@wishdestroy')->name('ShopRemoveWishlist');
Route::get('/orders', 'ShopController@orderhistory')->name('ShopOrderHistory');
Route::get('/wishlist', 'ShopController@wishlist')->name('ShopMyWishlist');

Route::get('/about', 'ShopController@about')->name('ShopAbout');
