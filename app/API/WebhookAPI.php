<?php

namespace App\API;


use Illuminate\Http\Response;

class WebhookAPI extends ParentAPI {

    /**
     * API URL to communicate with webhook API.
     *
     * @var string
     */
    private $_apiURL;

    public function __construct() {
        parent::__construct();

        $this->_apiURL = $this->getBuiltUrl("helix");
    }

    /**
     * Subscribe to topics via webhooks
     *
     * @param string $topic
     *
     * @return bool
     * @throws \Exception
     */
    public function subscribeToWebHook($topic) {
        $url = $this->_apiURL.'/webhooks/hub';

        $response = $this->post(
            $url,
            [
                'json' => [
                    'hub.callback' => route("twitchWebhookGetCallback"),
                    "hub.mode" => "subscribe",
                    "hub.topic" => $topic,
                    "hub.lease_seconds" => getTwitchHubLeaseSeconds(),
                    "hub.secret" => getKeyForSigningWebhookMessage()
                ],
                "headers" => [
                    "Client-ID" => getTwitchClientID(),
                ]
            ]
        );

        return $response["status"] === Response::HTTP_ACCEPTED;
    }

}
