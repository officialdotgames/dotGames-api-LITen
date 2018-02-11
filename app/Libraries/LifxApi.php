<?php

namespace App\Libraries;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class LifxApi
{
    //group:AshOffice
    //id:deviceid
    public static function setSelectorProperity($selector, $authorization, $color = null, $power = null, $duration=null) {
        $url = "https://api.lifx.com/v1/lights/" . $selector . "/state";

        $body = (object)[];

        if(!is_null($color)) {
            $body->color = $color;
        }

        if(!is_null($power)) {
            $body->power = $power;
        }

        if(!is_null($duration)) {
            $body->duration = $duration;
        }

        $json = json_encode($body, JSON_UNESCAPED_SLASHES);
        return LifxApi::queryLifx("PUT", $url, $json, $authorization);
    }

    public static function getSelectorLights($selector, $authorization) {
        $url = "https://api.lifx.com/v1/lights/" . $selector;

        $json = json_encode($body, JSON_UNESCAPED_SLASHES);
        return LifxApi::queryLifx("PUT", $url, $json, $authorization);
    }

    public static function queryLifx($verb, $url, $json, $authorization) {
        $client = new Client();

        try {
            $returned = $client->request($verb, $url, [
                'headers' => [
                    'Content-Type'  =>  'application/json',
                    'Authorization' =>  'Bearer ' . $authorization
                ],
                'body' => $json
            ]);

            $response = new \stdClass();

            $response->success = true;
            $response->response = json_decode($returned->getBody());

            return $response;

        } catch (\Exception $re){
            $response = new \stdClass();

            $response->success = false;
            $response->error = $re->getMessage();

            return $response;
        }
    }
}
