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
    Route::get('/resume/load', 'show@ResumesController'),

    Route::get('/profile', 'show@ProfileController'),
    Route::post('/profile', 'update@ProfileController'),
    Route::get('/profile/delete', 'destroy@ProfileController'),
    Route::get('/profile/edit', 'edit@ProfileController'),

    Route::get('/register/employer', 'showemployer@RegistrationController'),
    Route::get('/register/user', 'showuser@RegistrationController'),
    Route::post('/register/employer', 'employer@RegistrationController'),
    Route::post('/register/user', 'user@RegistrationController'),

    Route::get('/password/reset', 'show_password_reset@RegistrationController'),
    Route::post('/password/reset', 'password_reset@RegistrationController'),

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
