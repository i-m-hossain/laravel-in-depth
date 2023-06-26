<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class GeneralJsonException extends Exception
{
    protected $code = 422;
    /**
     * Report the exception
     *
     * @return void
     */
    public function report(){
        // here we can send error report or log to a log file
        // dump("ablfd");
    }

    /**
     * Render the exception as an HTTP response
     * @param  \Illuminate\Http\Request $request
     */
    public function render($request){
        return new JsonResponse([
            'errors'=>[
                "message"=>$this->getMessage()
            ]
            ], $this->code );
    }
}
