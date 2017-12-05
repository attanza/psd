<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
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
	

	// Media
	Route::post('media-upload', 'MediaController@upload');

});
