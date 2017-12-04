<?php
// Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard.index');

	Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
	// Areas
	Route::get('/areas', 'AreaController@index')->name('areas.index');
	// Market
	Route::get('/markets', 'MarketController@index')->name('markets.index');
	Route::get('/market/{id}', 'MarketController@show')->name('markets.show');
	// Product
	Route::get('/products', 'ProductController@index')->name('products.index');
	Route::get('/products/{id}', 'ProductController@show')->name('products.show');
	// Stokists
	Route::get('/stokists', 'StokistController@index')->name('stokists.index');
	Route::get('/stokists/{id}', 'StokistController@show')->name('stokists.show');

});