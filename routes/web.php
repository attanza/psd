<?php
// Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard.index');
    Route::get('/home', 'DashboardController@index')->name('dashboard.index');

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
	// Store
	Route::get('/stores', 'StoreController@index')->name('stores.index');
	Route::get('/stores/{id}', 'StoreController@show')->name('stores.show');
	// Outlet
	Route::get('/outlets', 'OutletController@index')->name('outlets.index');
	Route::get('/outlets/{id}', 'OutletController@show')->name('outlets.show');
	// Role
	// Route::get('/roles', 'RoleController@index')->name('roles.index');
	// Route::get('/roles/{id}', 'RoleController@show')->name('roles.show');
	// User
	Route::get('/users', 'UserController@index')->name('users.index');
	Route::get('/users/{id}', 'UserController@show')->name('users.show');

	Route::get('profile', 'ProfileController@index')->name('profile.index');

});