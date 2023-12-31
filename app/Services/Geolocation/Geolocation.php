<?php
namespace App\Services\Geolocation;

use App\Services\Geolocation\Map\Map;
use App\Services\Geolocation\Satellite\Satellite;

class Geolocation{
    private $map;
    private $satellite;
    public function __construct(Map $map, Satellite $satellite){
        $this->map = $map;
        $this->satellite = $satellite;
    }
    public function search(string $name){
        $location =  $this->map->findAddress($name);
        $coordinates = $this->satellite->pinpoint($location);
        return $coordinates;
    }

}
