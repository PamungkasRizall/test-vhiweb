<?php 

$router->group([
    'prefix' => 'photos', 
    'as' => 'photos'
], function () use ($router) {

    /* get photos */
    $router->get('/', ['uses' => 'PhotoController@index']);

    /* show */
    $router->get('/{id}', ['uses' => 'PhotoController@show']);

    /* restrict route */
    $router->group(['middleware' => 'auth'], function () use ($router) {

        /* store */
        $router->post('/', ['uses' => 'PhotoController@store']);

        /* update */
        $router->put('/{id}', ['uses' => 'PhotoController@update']);

        /* delete */
        $router->delete('{id}', ['uses' => 'PhotoController@destroy']);

        /* like */
        $router->post('/{id}/like', ['uses' => 'PhotoController@like']);

        /* unlike */
        $router->post('/{id}/unlike', ['uses' => 'PhotoController@unlike']);

    });

});