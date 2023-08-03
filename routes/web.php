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

Route::get('/dashboard', 'UserController@index')->name('User Controller');
Route::get('/about', 'UserController@about')->name('About Page');
Route::post('/updateAccount/{id}', 'UserController@updatePassword')->name('User Password');
Route::get('/mail', 'UserController@sendEmail');

Route::get('/reviewItem', 'ReviewController@index')->name('Add Review');

Route::get('/', 'ShopController@index')->name('ShopController');
Route::get('/viewItem/{id}', 'ShopController@show')->name('View Item');

Route::post('/checkout', 'CartController@index')->name('Cart Checkout');
Route::get('/viewCart/{id}', 'CartController@show')->name('Show Cart');
Route::post('/addtocart', 'CartController@store')->name('Cart Add');
Route::post('/AddOrder', 'CartController@create')->name('Add Order');
Route::post('/deletecart/', 'CartController@destroy')->name('Cart Destroy');
Route::any('/deleteItem/', 'CartController@deleteItem')->name('Cart Item Delete');

Route::get('/wishlist', 'WishController@index')->name('Show Wish');
Route::post('/wishlist', 'WishController@store')->name('Add Wish');
Route::post('/removewish', 'WishController@destroy')->name('Destroy Wish');

Route::get('/orders', 'OrderController@index')->name('Show Order');
Route::get('/viewOrder/{orderNum}', 'OrderController@show')->name('View Order');
Route::post('/DeleteOrder', 'OrderController@destroy')->name('Delete Order');

