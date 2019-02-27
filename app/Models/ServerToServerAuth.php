<?php

namespace App\Models;


class ServerToServerAuth {

    /**
     * oAuth Token used in webhook API
     * @var string
     */
    public $accessToken;

    /**
     * Expiry time for the token
     *
     * @var int
     */
    public $expiresIn;

    /**
     * Scopes that were applied to by the user
     *
     * @var array
     */
    public $scopes;

    /**
     * Token type
     *
     * @var string
     */
    public $tokenType;

    /**
     * @param string $rawData
     *
     * @return ServerToServerAuth
     */
    public function getModel($rawData) {
        $decodedRawData = json_decode($rawData, true);
        $instance = new self();

        $instance->accessToken = $decodedRawData["access_token"];
        $instance->expiresIn = $decodedRawData["expires_in"];
        $instance->scopes = $decodedRawData["scope"];
        $instance->tokenType = $decodedRawData["token_type"];

        return $instance;
    }

}
