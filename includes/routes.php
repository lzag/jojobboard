<?php
use App\Route;
use App\Middleware\Login;

return [
    Route::get('/'),
    Route::get('/home'),
    Route::get('/login'),
    Route::post('/login'),
];

// $router->wrap(
    // [App\Middleware\Login],
    // [
        // Route::get('users'),
        // Route::get('jobposts'),
    // ]
// );
