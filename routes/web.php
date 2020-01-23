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
Auth::routes(['verify'=>true]);
Route::resources([
    'category' => 'CategoryController',
    'item' => 'ItemController',
    'news' => 'NewsController',
    'card' => 'CardController',
    'order' => 'OrderController'
]);
Route::get('/', 'NewsController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin/items', 'ItemController@admin_index')->name('item.admin_index');
Route::get('/admin/order', 'OrderController@admin_index')->name('order.admin_index');
Route::get('/myCart', 'CardController@index');



//Route::get('/order', 'OrderController@index')->name('order.index');
//Route::post('/order', 'OrderController@store')->name('order.store');
//Route::DELETE('/order/{order}', 'OrderController@destroy')->name('order.destroy');
//Route::get('/order/{order}/edit', 'OrderController@edit')->name('order.edit');
