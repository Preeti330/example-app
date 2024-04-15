<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/product');


// Route::get('/', function () {
//     return view('user',['name'=>'preeti']);
// });
Route::get('/user/{id}', 'App\Http\Controllers\UserController@getuserdetails')->name('user');

Route::get('/product', function(){
    return view('product',['product'=>Product::all()]);
})->name('product');


Route::get('/thankyou', function () {
    return view('thankyou', ['msg' => 'Thank You for Your Order']);
})->name('thankyou');

Route::get('/product/{id}', 'App\Http\Controllers\ProductController@getproductbyid')->name('productdetail');

Route::post('/cart', 'App\Http\Controllers\CartController@addcart')->name('cart');

// Route::get('/order/{user_id}/{product_id}', 'App\Http\Controllers\OrderController@getorder')->name('orderid');

Route::post('/order', 'App\Http\Controllers\OrderController@placeorder')->name('order');

Route::get('/cart/{user_id}/{cart_id}', 'App\Http\Controllers\CartController@getcartitem')->name('getcart');
// Route::get('/order', 'OrderController@index')->name('order');

