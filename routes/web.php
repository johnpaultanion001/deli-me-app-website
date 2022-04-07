<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/customer/home');

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('optimize:clear');
});

// Route::get('/', 'LandingpageController@index')->name('landingpage');
Route::get('view/{product}', 'LandingpageController@view')->name('view');


Route::group(['prefix' => 'customer', 'as' => 'customer.', 'namespace' => 'Customer', 'middleware' => ['auth']], function () {
    Route::get('/approve', function() {
           return view('auth.checkapprove');
         });
 });

Auth::routes();

Route::group(['prefix' => 'customer', 'as' => 'customer.', 'namespace' => 'Customer', 'middleware' => ['auth', 'checkapproved']], function () {
   
    // Home
    Route::get('home', 'HomeController@index')->name('home');

    // seach and filter
    Route::get('home/filter', 'HomeController@filter')->name('filter');

    //Add To Cart
    Route::post('addtocart', 'OrderController@addtocart')->name('addtocart');
    Route::get('orders', 'OrderController@orders')->name('orders');
    Route::get('orders/{order}', 'OrderController@edit_order')->name('edit_order');
    Route::put('orders/{order}', 'OrderController@update_order')->name('update_order');
    Route::delete('orders/{order}', 'OrderController@destroy_order')->name('destroy_order');
    Route::get('orders_history', 'OrderController@orders_history')->name('orders_history');

    //Check Out
    Route::post('checkout', 'OrderController@checkout')->name('checkout');

    //Profile
    Route::get('profile', 'HomeController@profile')->name('profile');

});

