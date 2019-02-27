<?php

namespace App\Http\Controllers;

use App\API\SearchAPI;
use App\Utilities\Logger;
use Exception;

class HomeController extends Controller
{
    /**
     * @var SearchAPI
     */
    private $_searchAPI;

    /**
     * @var Logger
     */
    private $_logger;

    public function __construct(SearchAPI $searchAPI) {
        $this->_searchAPI = $searchAPI;
        $this->_logger = Logger::getInstance();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showHomePage()
    {
        return view('pages.home');
    }

    /**
     * Get channels table based on the results from Twitch API and send it to front-end
     *
     * @return array
     *
     * @throws Exception
     * @throws \Throwable
     */
    public function getChannelsTable() {
        $response = [
            'status' => false,
            'view' => ""
        ];

        try {
            if(!empty(request()->get("searchParam"))) {
                $searchResults = $this->_searchAPI->searchChannels(request()->get("searchParam"));
            } else if(!empty(request()->get("paginationURL"))) {
                $searchResults = $this->_searchAPI->paginateChannel(request()->get("paginationURL"));
            }

            if(!empty($searchResults)) {
                $response["status"] = true;
                $response["view"] = view("pages.partials.channel_listing",
                    [
                        "channels" => $searchResults["channels"],
                        "nextURL"  => isset($searchResults["nextURL"]) ? $searchResults["nextURL"] : "",
                        "previousURL" => isset($searchResults["previousURL"]) ? $searchResults["previousURL"] : ""
                    ]
                )->render();
            }
        } catch (Exception $exception) {
            $this->_logger->log($exception, self::class);
        }

        return $response;
    }
}
