<?php

Route::group(['prefix' => 'api/v1'], function () {
    Route::resource('categories', 'Urbn8\Wos\Http\RestEventCategories');
    Route::resource('organisers', 'Urbn8\Wos\Http\Organisers');
});
