<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
    [
        'middleware' => [
            'api'
        ]
    ],

    function () {
        Route::get(
            '/twitch-webhook-callback',
            [
                'as' => 'twitchWebhookGetCallback',
                'uses' => 'WebhookController@twitchWebhookGetCallback'
            ]
        );

        Route::post(
            '/twitch-webhook-callback',
            [
                'as' => 'twitchWebhookPostCallback',
                'uses' => 'WebhookController@twitchWebhookPostCallback'
            ]
        );
    }
);