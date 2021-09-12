<?php
use App\Route;
use App\Middleware\Login;

return [
    Route::get('/'),
    Route::get('/home'),

    Route::get('/login', 'index@LoginController'),
    Route::post('/login', 'login_user@LoginController'),
    Route::get('/logout', 'destroy@LoginController'),

    Route::get('/users'),

    Route::get('/blog'),

    Route::get('/resume'),
    Route::post('/resume'),

    Route::get('/applications'),
    Route::post('/applications'),
    Route::delete('/applications'),

    Route::delete('/account'),
];

// $router->wrap(
    // [App\Middleware\Login],
    // [
        // Route::get('users'),
        // Route::get('jobposts'),
    // ]
// );
