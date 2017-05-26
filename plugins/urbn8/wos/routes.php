<?php

Route::group(['prefix' => 'api/v1', 'middleware' => [
  'jwt-auth' => '\Tymon\JWTAuth\Middleware\GetUserFromToken',
  // 'jwt.refresh' => '\Tymon\JWTAuth\Middleware\RefreshToken'
]], function () {
    // Route::resource('categories', 'Urbn8\Wos\Http\RestEventCategories');
    // Route::resource('organisers', 'Urbn8\Wos\Http\Organisers');
    // Route::resource('events', 'Urbn8\Wos\Http\RestEvents');
});
