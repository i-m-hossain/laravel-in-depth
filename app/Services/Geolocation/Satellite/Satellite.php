<?php
namespace App\Services\Geolocation\Satellite;


class Satellite{
    public function pinpoint(string $info){
        return [
            'lat' => 123,
            'lng' => 456,
            'info'=> $info
        ];
    }
}
