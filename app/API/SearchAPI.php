<?php

namespace App\API;


use App\Models\Channel;
use Illuminate\Http\Response;

class SearchAPI extends ParentAPI {

    /**
     * Generic URL to use throughout search API.
     *
     * @var string
     */
    private $_apiURL;

    public function __construct() {
        parent::__construct();

        $this->_apiURL = $this->getBuiltUrl("kraken/search");
    }

    /**
     * Search channels on twitch and return a model array for all channels.
     *
     * @param $searchParam
     *
     * @return null|array
     *
     * @throws \Exception
     */
    public function searchChannels($searchParam) {
        $url = $this->_apiURL."/channels?query=$searchParam";

        $data = null;

        $response = $this->get(
            $url,
            [
                "Client-ID" => getTwitchClientID()
            ]
        );

        if($response['status'] === Response::HTTP_OK) {
            $channelModel = new Channel();
            $data = $channelModel->getChannelsArray($response['body']);
        }

        return $data;
    }

    /**
     * Call the paginated URL for channel
     *
     * @param $url
     *
     * @return null|array
     *
     * @throws \Exception
     */
    public function paginateChannel($url) {
        $data = null;

        $response = $this->get(
            $url,
            [
                "Client-ID" => getTwitchClientID()
            ]
        );

        if($response['status'] === Response::HTTP_OK) {
            $channelModel = new Channel();
            $data = $channelModel->getChannelsArray($response['body']);
        }

        return $data;
    }

}
