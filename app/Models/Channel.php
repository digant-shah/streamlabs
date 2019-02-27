<?php

namespace App\Models;

class Channel {

    public $logo;

    public $name;

    public $displayName;

    public $channelID;

    /**
     * Given a channel map it to the model and return it.
     *
     * @return Channel
     *
     * @param array $datum
     */
    public function getChannel($datum = []) {
        $instance = new self();

        $instance->logo = $datum["logo"];
        $instance->name = $datum["name"];
        $instance->displayName = $datum["display_name"];
        $instance->channelID = $datum["_id"];

        return $instance;
    }

    /**
     * Given raw data, parse it and return array of channel models
     *
     * @return array
     *
     * @param $rawData
     */
    public function getChannelsArray($rawData) {
        $decodedRawData = json_decode($rawData, true);
        $methodResponse = [
            "channels" => []
        ];

        foreach ($decodedRawData["channels"] as $channel) {
            $methodResponse["channels"][] = $this->getChannel($channel);
        }

        if(!empty($decodedRawData["_links"]["next"])) {
            $methodResponse["nextURL"] = $decodedRawData["_links"]["next"];
        }

        if(!empty($decodedRawData["_links"]["prev"])) {
            $methodResponse["previousURL"] = $decodedRawData["_links"]["prev"];
        }

        return $methodResponse;
    }

}
