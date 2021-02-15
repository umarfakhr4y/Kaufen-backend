<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
$url = "App\Http\Controllers";

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'App\Http\Controllers\UserController@login')->middleware('cekverified')->name('login');


Route::post('/email/resend',$url . '\VerificationApiController@resend')->name('verification.resend');   
Route::get('/email/verify/{id}', $url .'\VerificationApiController@verify')->name('verification.verify');


// All Users
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('/logout', 'App\Http\Controllers\UserController@logout');
    Route::get('user/detail', 'App\Http\Controllers\UserController@details');                       // Detail Current User
    Route::get('/barang-koperasi/history', 'App\Http\Controllers\KoperasiController@history');      // History Barang Koperasi

    // Update User
        Route::put('/user/update-profile', 'App\Http\Controllers\UserController@updateProf');       // Update Profile
        Route::put('/user/update-pass', 'App\Http\Controllers\UserController@updatePass');          // Change Password

    // Delete User
        Route::delete('/user/delete', 'App\Http\Controllers\UserController@delete');                // self deleting

    // Data Diri
        Route::post('/data/data-diri', 'App\Http\Controllers\DataController@store');                // Add data diri    
        //Route::get('/data/show', 'App\Http\Controllers\DataController@showSelf');                   // show data diri diambil dari user/detail
        Route::put('/data/edit', 'App\Http\Controllers\DataController@updateSelf');                   // show data diri



// REKAPAN
    Route::get('/barang-koperasi/show', 'App\Http\Controllers\KoperasiController@index');           // Koperasi
    Route::get('/barang-penjual/show', 'Aapp\Http\Controllers\BarangController@index');              // Barang Titipan
    Route::get('/loan/show', 'App\Http\Controllers\DepositController@index');                       // Peminjaman
    Route::get('/nabung/show', 'App\Http\Controllers\DepositController@index');                     // Tabungan
    
});

// Access Verified Email
// Route::group(['middleware' => 'auth:api', 'verified'], function() {

// }); 

// Admin Role
Route::group(['middleware' => ['auth:api', 'role:admin']], function() {        
    Route::get('/user/{role}', 'App\Http\Controllers\UserController@getUsersByRole');               // Get All User By Role   
    Route::get('/users', 'App\Http\Controllers\UserController@allDetails');                         // Get All User With Data
    Route::post('/register', 'App\Http\Controllers\UserController@register');

    Route::resource('/data', 'App\Http\Controllers\DataController');                                // Full Controll data diri all members
    Route::resource('/pinjam', 'App\Http\Controllers\LoansController');
    Route::resource('/nabung', 'App\Http\Controllers\DepositController');    
    Route::resource('/barang-koperasi', 'App\Http\Controllers\KoperasiController'); 
    Route::resource('/barang-penjual', 'App\Http\Controllers\BarangController');
    Route::delete('/user/delete/{id}', 'App\Http\Controllers\UserController@deleteMember');         // Delete Member


});


// Anggota Role
 Route::group(['middleware' => ['auth:api', 'role:anggota']], function() {
    
});


// penjual Role
Route::group(['middleware' => ['auth:api', 'role:penjual']], function() {    
    Route::put('barang-koperasi-transaksi/update/{id}', 'App\Http\Controllers\KoperasiController@update'); // Transakasi Barang Koperasi
    Route::put('/barang-penjual-transaksi/update/{id}', 'App\Http\Controllers\BarangController@update');   // Transaksi Barang Titipan
    Route::put('/barang-penjual/stock/{id}', 'App\Http\Controllers\BarangController@decStock');
    Route::put('/barang-koperasi/stock/{id}', 'App\Http\Controllers\KoperasiController@decStock');
});

