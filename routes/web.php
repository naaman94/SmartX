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
Auth::routes(['verify' => true]);//by email
Route::resources([
    'item' => 'ItemController',
    'news' => 'NewsController'
]);
Route::get('/admin/items', 'ItemController@admin_index')->name('item.admin_index');


Route::get('/', 'HomeController@welcome')->name('welcome');
Route::get('/home', 'HomeController@index')->name('home');


Route::resource('category', 'CategoryController')->except(['show']);

Route::resource('card', 'CardController')->except(['index','show', 'create', 'edit']);
Route::get('/myCart', 'CardController@index')->name('mycart');

Route::resource('order', 'OrderController')->except(['show','edit', 'destroy']);
Route::get('/admin/order', 'OrderController@admin_index')->name('order.admin_index');


//  index', 'show', 'edit', 'create', 'store', 'update', 'destroy'
