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

// Route::get('/', function () {
//     return view('dashboard');
// });

// Route::get('pos', function () {
//     return view('pos.index');
// });

// Route::get('login', function () {
//     return view('login');
// });


Route::group(['middleware' => 'guest'], function(){
    Route::group(['middleware' => 'revalidate'], function () {
        Route::get('/',              'HomeController@index')->name('login');
        Route::post('authenticate',  'HomeController@login');
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'revalidate'], function () {
        Route::get('/dashboard',      'HomeController@dashboard');
        Route::post('logout',         'HomeController@logout')->name('logout');
        Route::get('logout2',         'HomeController@logout')->name('logout');
        Route::post('changepassword', 'HomeController@changepassword')->name('changepassword');
    });
    
    Route::get('pos', function () {
        return view('pos.index');
    });
    Route::post('/finditemmaster', 'Master\ItemMasterController@findItem');
    Route::get('/itemmaster', 'Master\ItemMasterController@itemList');
});
