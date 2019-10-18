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

// Route::get('/', function () {
//     return view('login');
// });

Route::get('/', 'LoginController@index');
Route::get('/login', 'LoginController@index')->name('login');
Route::post('/auth', 'LoginController@authLogin');
Route::get('/logout', 'LoginController@logout');

Route::group(['middleware' => ['auth','CheckUserRole:admin,manajemen,gudang,kasir']], function () {
    
});

Route::group(['middleware' => ['auth','CheckUserRole:admin,manajemen']], function () {

    Route::get('/dashboard', 'DashboardController@index');
    
});

Route::group(['middleware' => ['auth','CheckUserRole:admin,manajemen,kasir']], function () {

    Route::get('/penjualan', 'PenjualanController@index');
    
});

Route::group(['middleware' => ['auth','CheckUserRole:admin,manajemen,gudang']], function () {
    
    Route::resource('produksi/produk', 'ProduksiController');
    Route::get('/produksi/produk/{id}/delete', 'ProduksiController@delete');
    Route::get('/produksi', 'ProduksiController@dashboard');

});
