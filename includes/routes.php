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

    Route::get('/jobad', 'create@JobadsController'),
    Route::post('/jobad', 'store@JobadsController'),

    Route::get('/jobads', 'index@JobadsController'),

    Route::get('/blog'),

    Route::get('/resume', 'index@ResumesController'),
    Route::post('/resume', 'upload@ResumesController'),

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
