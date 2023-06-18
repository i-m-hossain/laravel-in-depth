<?php
namespace App\Services\Satellite;


class Satellite{
    public function pinpoint(string $info){
        return [
            'lat' => 123,
            'lng' => 456,
            'info'=> $info
        ];
    }
}
