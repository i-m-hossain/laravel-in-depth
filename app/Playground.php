<?php

namespace App;

use App\Services\Geolocation\Geolocation;
use App\Services\Geolocation\GeolocationFacade;

class Playground{
    public function __construct(Geolocation $geolocation){
        //using dependency injection
        // $result = $geolocation->search('Bali');
        //using app container
        // $result = app("App\Services\Geolocation\Geolocation")->search('Bali hello');
        //using facade
        $result = GeolocationFacade::search('Bali again');
        dump($result);
    }
}
