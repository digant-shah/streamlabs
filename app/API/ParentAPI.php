<?php

namespace App\API;

use GuzzleHttp\Client;
use Exception;
use GuzzleHttp\Exception\ClientException;
use App\Utilities\Logger;

class ParentAPI {
    private $_httpClient = null;

    public function __construct() {
        $this->_httpClient = new Client();
    }

	/**
	 * Get Build URL method
	 *
	 * @param string $urlPart
     *
	 * @return string
	 */
    protected function getBuiltUrl($urlPart) {
        return getTwitchAPIURL().'/'.$urlPart;
    }

	/**
	 * Get Method call
	 *
	 * @param string $url
	 * @param array $headers
	 *
	 * @return array
	 * @throws Exception
	 */
    protected function get($url, $headers = []) {
        $result = [
            'status' => -1,
            'body' => ''
        ];

        try {
            $options = [];

            if(!empty($headers)) {
                $options["headers"] = $headers;
            }

            $response = $this->_httpClient->get($url, $options);

            $result['status'] = $response->getStatusCode();
            $result['body'] = $response->getBody()->getContents();
        } catch (Exception $exception) {
            Logger::getInstance()->log($exception, self::class);
        }

        return $result;
    }

	/**
	 * Put method Call
	 *
	 * @param string $url
	 * @param array $options
	 *
	 * @return array
	 * @throws Exception
	 */
    protected function put($url, $options) {
        $result = [
            'status' => -1
        ];

        try {
            $response = $this->_httpClient->put($url, $options);
            $result['status'] = $response->getStatusCode();
            $result['body'] = $response->getBody();
        } catch (Exception $exception) {
            Logger::getInstance()->log($exception, self::class);
        }

        return $result;
    }

	/***
	 * Post method
	 *
	 * @param $url
	 * @param $options
	 *
	 * @return array
	 * @throws Exception
	 */
    protected function post($url, $options)
    {
        $result = [
            'status' => -1
        ];
        try {
            $response = $this->_httpClient->post($url, $options);
            $result['status'] = $response->getStatusCode();
            $result['body'] = $response->getBody();
        } catch(ClientException $exception) {
            $result['status'] = $exception->getResponse()->getStatusCode();
            $result['body'] = $exception->getResponse()->getBody();
            //if json object json_decode
            if(is_object($result['body'])) {
                $result['body'] = json_decode($result['body']);
            }
        } catch (Exception $exception) {
            Logger::getInstance()->log($exception, self::class);
        }
        return $result;
    }

	/**
	 * Delete method
	 *
	 * @param string $url
	 * @param array $options
	 *
	 * @return array
	 * @throws Exception
	 */
    protected function delete($url, $options = []) {
	    $result = [
		    'status' => -1
	    ];

	    try {
		    $response = $this->_httpClient->delete($url, $options);
		    $result['status'] = $response->getStatusCode();
	    } catch (Exception $exception) {
		    Logger::getInstance()->log($exception, self::class);
	    }

	    return $result;
    }
}