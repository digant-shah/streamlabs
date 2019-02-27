<?php
namespace App\Http\Controllers;


use App\Events\UserGotFollower;
use App\Utilities\Logger;
use Exception;
use Illuminate\Http\Response;

class WebhookController extends Controller {

    /**
     * @var Logger
     */
    private $_logger;

    public function __construct() {
        $this->_logger = Logger::getInstance();
    }

    /**
     * Receive the twitch callbacks for events.
     *
     * @return string
     *
     * @throws Exception
     */
    public function twitchWebhookGetCallback() {
        $response = null;

        try {
            $hubMode = request()->get("hub_mode");
            $hubLeaseSeconds = request()->get("hub_lease_seconds");
            $hubChallenge = request()->get("hub_challenge");
            
            if($hubMode === "denied") {
                event(new UserGotFollower(request()->all()));
            } else {
                if(!empty($hubMode) && !empty($hubLeaseSeconds) && !empty($hubChallenge)) {
                    $response = $hubChallenge;
                }
            }
        } catch (Exception $exception) {
            $this->_logger->log($exception, self::class);
        }

        return response($response, Response::HTTP_OK);
    }

    /**
     * Event ocurred, send the notification to front-end.
     *
     * @throws Exception
     */
    public function twitchWebhookPostCallback() {
        try {
            event(new UserGotFollower(request()->all()));
        } catch (Exception $exception) {
            $this->_logger->log($exception, self::class);
        }
    }

}
