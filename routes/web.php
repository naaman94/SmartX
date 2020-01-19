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
Route::get('/', 'NewsController@index');


Auth::routes();

route::resource('category','CategoryController');

Route::get('/home', 'HomeController@index')->name('home');
route::resource('item','ItemController');
route::resource('order','OrderController');
route::resource('news','NewsController');
route::resource('card','CardController')->middleware('admin','auth');
//Route::group(['middleware'=>['auth','admin']],function (){
// });
