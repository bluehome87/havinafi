<?php

// all WEB requests go here (for both authenticated users and guests)
Route::group(['middleware' => ['web']], function () {
    // separate GET rule leading to logout page
    $this->get('logout', 'Auth\AuthController@logout');
    // separate GET rule leading to reset password page
    $this->get('reset-password/{token?}', 'Auth\PasswordController@showResetForm');

    // rule matching all GET requests and redirecting them to app
    Route::match(['get'], '{all?}', 'PagesController@index');

    // collection of separate POST rules
    $this->post('register', 'Auth\AuthController@register');
    $this->post('login', 'Auth\AuthController@login');
    $this->post('forgot-password', 'Auth\PasswordController@sendResetLinkEmail');
    $this->post('reset-password', 'Auth\PasswordController@reset');

});

// all WEB requests for AUTHenticated users go here
Route::group(['middleware' => 'web', 'auth'], function () {
    // rule matching all GET requests and redirecting them to app
    Route::match(['get'], 'view-vehicle/{id}', 'PagesController@indexUser');
    Route::match(['get'], 'view-task/{id}', 'PagesController@indexUser');
    Route::match(['get'], 'view-job/{id}', 'PagesController@indexUser');
    Route::match(['get'], 'view-transport-time/{id}', 'PagesController@indexUser');
    Route::match(['get'], 'view-transport-tasks/{id}', 'PagesController@indexUser');
    Route::match(['get'], 'edit-job/{id}', 'PagesController@indexUser');
    Route::match(['get'], '{all?}', 'PagesController@indexUser');


    // collection of separate POST rules
    $this->post('profile', 'UserController@update');

    // Vehicle routing
    $this->post('create-vehicle', 'VehicleController@create');
    $this->post('get-vehicle-info/{id}', 'VehicleController@getInfo');
    $this->post('edit-vehicle/{id}', 'VehicleController@update');
    $this->post('get-vehicle-list', 'VehicleController@getList');
    $this->post('delete-vehicle/{id}', 'VehicleController@delete');
    $this->post('clone-vehicle/{id}', 'VehicleController@duplicate');

    // Task routing
    $this->post('create-task', 'TaskController@create');
    $this->post('get-task-info/{id}', 'TaskController@getInfo');
    $this->post('edit-task/{id}', 'TaskController@update');
    $this->post('get-task-list', 'TaskController@getList');
    $this->post('delete-task/{id}', 'TaskController@delete');
    $this->post('clone-task/{id}', 'TaskController@duplicate');

    // Optimization Problem routing
    $this->post('optimize-problem', 'ProblemController@sendProblem');
    $this->post('get-job-driving-list/{id}', 'ProblemController@getJobDrivingList');
    $this->post('get-job-details/{id}', 'ProblemController@getJobDetails');
    $this->post('get-jobs-list', 'ProblemController@getList');
    $this->post('get-edit-job-details/{id}', 'ProblemController@getEditDetails');
    $this->post('update-problem/{id}', 'ProblemController@updateProblem');
    $this->post('delete-problem/{id}', 'ProblemController@delete');
    $this->post('clone-problem/{id}', 'ProblemController@duplicate');
});