<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'address'], function () {
    Route::get('get-location-type-children', 'LocationsController@getLocationTypeChildren');
    Route::post('locations/bulk-action', 'LocationsController@bulkAction');
    Route::resource('locations', 'LocationsController');
});
