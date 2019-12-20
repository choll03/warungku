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

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/cart','CartController@index')->name('cart.index');
    Route::post('/cart','CartController@add')->name('cart.add');
    Route::post('/cart/conditions','CartController@addCondition')->name('cart.addCondition');
    Route::delete('/cart/conditions','CartController@clearCartConditions')->name('cart.clearCartConditions');
    Route::get('/cart/details','CartController@details')->name('cart.details');
    Route::delete('/cart/{id}','CartController@delete')->name('cart.delete');
    
    Route::get('/get_barang', 'BarangController@getData')->name('getBarang');
    Route::get('/get_barang_transaksi', 'TransaksiController@getData')->name('getBarangForTransaksi');
    Route::resource('/warung', 'WarungController');

    Route::middleware(['has.warung'])->group(function () {
        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('/transaksi', 'TransaksiController@index')->name('transaksi');
        Route::get('/laporan', 'HomeController@index')->name('laporan');
        Route::resource('/barang', 'BarangController');
    });
});
