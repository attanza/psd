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
	Route::get('/areas', 'AreaController@index')->name('area.index');
});