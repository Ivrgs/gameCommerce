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
Route::get('/about', 'HomeController@about')->name('About Page');
Route::post('/updateAccount/{id}', 'HomeController@updatePassword')->name('User Password');
Route::get('/mail', 'HomeController@sendEmail');

Route::get('/reviewItem', 'ReviewController@index')->name('Add Review');

Route::get('/', 'ShopController@index')->name('ShopController');
Route::get('/viewItem/{id}', 'ShopController@show')->name('View Item');

Route::post('/addtocart', 'CartController@store')->name('Cart Add');
Route::get('/viewCart/{id}', 'CartController@show')->name('Show Cart');
Route::post('/deletecart/{id}', 'CartController@destroy')->name('Cart Destroy');
Route::post('/checkout', 'CartController@create')->name('Cart Checkout');

Route::post('/removewish', 'WishController@destroy')->name('Destroy Wish');
Route::post('/wishlist', 'WishController@store')->name('Add Wish');
Route::get('/wishlist', 'WishController@index')->name('Show Wish');

Route::get('/orders', 'OrderController@index')->name('Show Order');
Route::get('/viewOrder/{orderNum}', 'OrderController@show')->name('View Order');

