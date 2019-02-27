<?php

namespace App\API;


use App\Models\ServerToServerAuth;
use Illuminate\Http\Response;

class AuthAPI extends ParentAPI {
    private $_apiURL;

    public function __construct() {
        parent::__construct();

        $this->_apiURL = getTwitchAuthAPIURL()."/token";
    }

    /**
     * Get the auth for server to server communication.
     *
     * @param array $scopes
     *
     * @return ServerToServerAuth|null
     * @throws \Exception
     */
    public function getOAuthForServerToServerCommunication($scopes = []) {
        $scopes = implode("&", $scopes);

        $url = $this->_apiURL.
               "?client_id=".getTwitchClientID().
               "&client_secret=".getTwitchClientSecret().
               "&grant_type=client_credentials".
               "scope=$scopes";
        $model = null;

        $response = $this->post($url, []);

        if($response["status"] === Response::HTTP_OK) {
            $serverToServerAuth = new ServerToServerAuth();
            $model = $serverToServerAuth->getModel($response["body"]);
        }

        return $model;
    }

}
