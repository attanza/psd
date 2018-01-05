<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => '\Api\Auth'], function(){
    Route::post('register', 'RegisterController@register');
    Route::post('login', 'LoginController@login');
    Route::post('refresh', 'LoginController@refresh');
    Route::post('activate', 'ActivationController@activate');
});

Route::group(['middleware' => 'auth:api'], function () {
	// area
	Route::post('area-list', 'AreaController@getAreaList')->name('area.list');
	Route::post('area', 'AreaController@store')->name('area.store');
	Route::put('area/{id}', 'AreaController@update')->name('area.update');
	Route::get('area/for/combo', 'AreaController@getAreaForCombo')->name('area.for_combo');

	// market
	Route::post('market-list', 'MarketController@getMarketList')->name('market.list');
	Route::post('market', 'MarketController@store')->name('market.store');
	Route::put('market/{id}', 'MarketController@update')->name('market.update');
	Route::put('market/{id}/location', 'MarketController@saveLocation')->name('market.location');
	Route::get('market/for/combo', 'MarketController@getMarketForCombo')->name('market.for_combo');
	Route::get('market/byArea/{areaId}', 'MarketController@getMarketByAreaId')->name('market.byArea');

	// product
	Route::post('product-list', 'ProductController@getProductList')->name('product.list');
	Route::post('product', 'ProductController@store')->name('product.store');
	Route::put('product/{id}', 'ProductController@update')->name('product.update');

	// stokist
	Route::post('stokist-list', 'StokistController@getStokistList')->name('stokist.list');
	Route::post('stokist', 'StokistController@store')->name('stokist.store');
	Route::put('stokist/{id}', 'StokistController@update')->name('stokist.update');
	Route::put('stokist/{id}/location', 'StokistController@saveLocation')->name('stokist.location');

	// store
	Route::post('store-list', 'StoreController@getstoreList')->name('store.list');
	Route::post('store', 'StoreController@store')->name('store.store');
	Route::put('store/{id}', 'StoreController@update')->name('store.update');
	Route::put('store/{id}/location', 'StoreController@saveLocation')->name('store.location');
	Route::get('store/for/combo', 'StoreController@getParentStore')->name('store.for_combo');
	Route::get('store/for/combo/{marketId}', 'StoreController@getParentByMarket')->name('store.by_market');

	// outlet
	Route::post('outlet-list', 'OutletController@getOutletList')->name('outlet.list');
	Route::post('outlet', 'OutletController@store')->name('outlet.outlet')->middleware('seller');
	Route::put('outlet/{id}', 'OutletController@update')->name('outlet.update');
	Route::put('outlet/{id}/location', 'OutletController@saveLocation')->name('outlet.location');
	// role
	// Route::post('role-list', 'RoleController@getroleList')->name('role.list');
	// Route::post('role', 'RoleController@store')->name('role.store');
	// Route::put('role/{id}', 'RoleController@update')->name('role.update');
	// User
	Route::post('user-list', 'UserController@getuserList')->name('user.list');
	Route::post('user', 'UserController@store')->name('user.store');
	Route::put('user/{id}', 'UserController@update')->name('user.update');
	Route::get('reset-password/{id}', 'UserController@resetPassword');
	// Media
	Route::post('media-upload', 'MediaController@upload');
	// Profile
	Route::put('profile', 'ProfileController@update');
	Route::post('profile/change-password', 'ProfileController@changePassword');
	// Sell Target
	Route::post('sell-target-list', 'SellTargetController@getTargetList')->name('target.list');
	Route::post('sell-target', 'SellTargetController@store')->name('target.store');
	

});
