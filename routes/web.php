<?php
Auth::routes(['verify' => true]);//by email
Route::get('/profile/edit', 'Auth\ProfileController@edit')->name('editProfile');
Route::post('/profile/edit', 'Auth\ProfileController@update')->name('editProfile');
Route::get('/profile', 'Auth\ProfileController@index')->name('profile');
Route::get('/profile/{profile}', 'Auth\ProfileController@show')->name('profile.show');
Route::get('/changePassword', 'Auth\ChanePasswordController@editPassword')->name('changePassword');
Route::post('/changePassword', 'Auth\ChanePasswordController@changePassword')->name('changePassword');
Route::resources([
    'item' => 'ItemController',
    'news' => 'NewsController'
]);
Route::get('/admin/items', 'ItemController@admin_index')->name('item.admin_index');
Route::get('/store', 'ItemController@index')->name('items.index');
Route::get('/', 'HomeController@home')->name('home');
Route::get('/home', 'HomeController@index')->name('index');
Route::resource('category', 'CategoryController')->except(['show']);
Route::resource('ads', 'AdController')->except(['show']);
Route::resource('card', 'CardController')->except(['index', 'show', 'create', 'edit']);
Route::get('/myCart', 'CardController@index')->name('mycart');
Route::resource('order', 'OrderController')->except(['show', 'edit', 'destroy']);
Route::get('/admin/order', 'OrderController@admin_index')->name('order.admin_index');
Route::post('/contact_us', 'SendEmailController@send')->name('send_email');

