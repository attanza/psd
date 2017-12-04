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

	// product
	Route::post('product-list', 'ProductController@getProductList')->name('product.list');
	Route::post('product', 'ProductController@store')->name('product.store');
	Route::put('product/{id}', 'ProductController@update')->name('product.update');

	// Media
	Route::post('media-upload', 'MediaController@upload');

});
