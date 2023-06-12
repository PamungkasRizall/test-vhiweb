<?php 

/* login */
$router->post('/login', [ 'as' => 'login', 'uses' => 'AuthController@login']);

/* restrict route */
$router->group(['middleware' => 'auth'], function () use ($router) {

    /* logout user */
    $router->get('/logout', [ 'as' => 'logout', 'uses' => 'AuthController@logout']);

    /* refresh token */
    $router->get('/refresh-token', [ 'as' => 'refreshToken', 'uses' => 'AuthController@refreshToken']);

});