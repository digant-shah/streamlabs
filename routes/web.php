<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'namespace' => 'Auth',
        'middleware' => [
            'guest',
            'web'
        ]
    ],

    function () {
        Route::get(
            '/',
            [
                'as' => 'showLoginView',
                'uses' => 'LoginController@showLoginView'
            ]
        );

        Route::get(
            '/o-auth/twitch-redirect',
            [
                'as' => 'twitchAuthRedirect',
                'uses' => 'LoginController@twitchAuthRedirect'
            ]
        );

        Route::get(
            '/o-auth/twitch-callback',
            [
                'as' => 'twitchAuthCallback',
                'uses' => 'LoginController@twitchAuthCallback'
            ]
        );
    }
);

Route::group(
    [
        'middleware' => [
            'auth',
            'web'
        ]
    ],

    function () {
        Route::get(
            '/home',
            [
                'as' => 'showHomePage',
                'uses' => 'HomeController@showHomePage'
            ]
        );

        Route::get(
            '/logout',
            [
                'as' => 'logout',
                'uses' => 'Auth\LoginController@logout'
            ]
        );

        Route::post(
            '/subscribe-to-channel',
            [
                'as' => 'subscribeToChannel',
                'uses' => 'TwitchSubscriptionController@subscribeToChannel'
            ]
        );

        Route::get(
            '/channel-stream',
            [
                'as' => 'getChannelStreamView',
                'uses' => 'TwitchSubscriptionController@getChannelStreamView'
            ]
        );

        Route::get(
            '/home/get-channels-table',
            [
                'as' => 'getChannelsTable',
                'uses' => 'HomeController@getChannelsTable'
            ]
        );
    }
);