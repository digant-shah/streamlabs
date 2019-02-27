<?php

namespace App\Utilities;

use GuzzleHttp\Exception\ConnectException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Log;
use Exception;

class Logger {
    private static $instance = null;

    private function __construct() {}

    public static function getInstance() {
        if(is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param Exception $exception
     * @param $callee
     * @throws Exception
     */
    public function log($exception, $callee) {
        $exceptionClass = get_class($exception);
        switch ($exceptionClass) {
            case AuthorizationException::class:
                abort(Response::HTTP_FORBIDDEN);
                break;
            case ConnectException::class:
                if(isAppDebuggable()) {
                    throw $exception;
                } else {
                    Log::error($exception->getTraceAsString(), [ $callee ]);
                    abort(Response::HTTP_INTERNAL_SERVER_ERROR);
                }
                break;
            default:
                if(isAppDebuggable()) {
                    throw $exception;
                } else {
                    Log::error($exception->getTraceAsString(), [ $callee ]);
                }
                break;
        }
    }
}