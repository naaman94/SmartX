<?php

Auth::routes(['verify' => true]);//by email

Route::get('/changePassword','Auth\ChanePasswordController@editPassword')->name('changePassword');
Route::post('/changePassword','Auth\ChanePasswordController@changePassword')->name('changePassword');
Route::get('/EditProfile','Auth\EditProfileController@edit')->name('editProfile');
Route::post('/EditProfile','Auth\EditProfileController@update')->name('editProfile');


Route::resources([
    'ads' => 'AdController',
    'item' => 'ItemController',
    'news' => 'NewsController'
]);
Route::get('/admin/items', 'ItemController@admin_index')->name('item.admin_index');


Route::get('/', 'HomeController@home')->name('home');


Route::resource('category', 'CategoryController')->except(['show']);

Route::resource('card', 'CardController')->except(['index','show', 'create', 'edit']);
Route::get('/myCart', 'CardController@index')->name('mycart');

Route::resource('order', 'OrderController')->except(['show','edit', 'destroy']);
Route::get('/admin/order', 'OrderController@admin_index')->name('order.admin_index');


//  index', 'show', 'edit', 'create', 'store', 'update', 'destroy'
