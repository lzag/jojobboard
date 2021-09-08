<?php
use App\Route;
use App\Middleware\Login;

return [
    Route::get('/login'),
    Route::post('/login'),
    Route::get('/index.php'),
];

// $router->wrap(
    // [App\Middleware\Login],
    // [
        // Route::get('users'),
        // Route::get('jobposts'),
    // ]
// );
