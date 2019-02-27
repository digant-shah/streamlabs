<?php

namespace App\Http\Controllers;


use App\API\AuthAPI;
use App\API\WebhookAPI;
use App\Objects\Enums\SessionKeys;
use App\Utilities\Logger;
use Mockery\Exception;

class TwitchSubscriptionController extends Controller {

    /**
     * @var Logger
     */
    private $_logger;

    /**
     * @var AuthAPI
     */
    private $_authAPI;

    /**
     * @var WebhookAPI
     */
    private $_webHookAPI;

    public function __construct(AuthAPI $authAPI, WebhookAPI $webHookAPI) {
        $this->_logger = Logger::getInstance();
        $this->_authAPI = $authAPI;
        $this->_webHookAPI = $webHookAPI;
    }

    /**
     * Provided a channel, subscribe to it and provide user realtime feed.
     *
     * @throws \Exception
     */
    public function subscribeToChannel() {
        $response = [
            'status' => false,
            'nextURL' => ""
        ];

        try {
            $channelID = request()->get("channelID");
            $channelName = request()->get("channelName");

            $userInfo = request()->session()->get(SessionKeys::USER_INFO);

            $userInfo->subscribedChannelName = $channelName;
            $userInfo->subscribedChannelID = $channelID;

            request()->session()->put(SessionKeys::USER_INFO, $userInfo);

            $isSubscriptionSuccessful = $this->_initiateWebHookSubscription($channelID);

            $response["status"] = true;
            $response["nextURL"] = route("getChannelStreamView",
                [
                    "isEventSubscribed" => $isSubscriptionSuccessful ? "true" : "false"
                ]
            );
        } catch (Exception $exception) {
            $this->_logger->log($exception, self::class);
        }

        return $response;
    }

    public function getChannelStreamView() {
        $userInfo = request()->session()->get(SessionKeys::USER_INFO);
        $isSubscriptionSuccessful = request()->get("isEventSubscribed") === "true";

        return view("pages.channel_stream",
            [
                "channelName" => $userInfo->subscribedChannelName,
                "channelID" => $userInfo->subscribedChannelID,
                "isSubscriptionSuccessful" => $isSubscriptionSuccessful
            ]
        );
    }

    /**
     * Given a channel ID initiate a subscription with webhooks.
     *
     * @param $channelID
     *
     * @return bool
     * @throws \Exception
     */
    private function _initiateWebHookSubscription($channelID) {
        $isSubscriptionSuccessful = false;

        try {
//            $authModel = $this->_authAPI->getOAuthForServerToServerCommunication(
//                [
//
//                ]
//            );
            $isSubscriptionSuccessful = $this->_webHookAPI->subscribeToWebHook(
                "https://api.twitch.tv/helix/users/follows?first=1&to_id=$channelID"
            );
        } catch (Exception $exception) {
            $this->_logger->log($exception, self::class);
        }

        return $isSubscriptionSuccessful;
    }

}
