<?php
// Tony Silvestri
// 11/4/21

declare(strict_types=1);

namespace Homework;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class ShippingRates {
    private $apiurl = "https://api.printful.com/shipping/rates";
    private $apikey = "77qn9aax-qrrm-idki:lnh0-fm2nhmp0yca7";
    private CacheInterface $cache;

    private function makeKey($data) {
        usort($data["items"], function($a, $b) {
            return $a["variant_id"] <=> $b["variant_id"];
        });
        return $data["recipient"]["zip"] . "?" . 
               $data["items"][0]["variant_id"] . "=" . $data["items"][0]["quantity"] . "?" .
               $data["items"][1]["variant_id"] . "=" . $data["items"][1]["quantity"];
    }

    public function __construct(CacheInterface $cache) {
        $this->cache = $cache;
    }

    public function GetShippingRate() {
        $json = json_encode($_POST);
        $key = $this->makeKey($_POST);
        if (($value = $this->cache->get($key)) != "") {
            return $value;
        }

        $client = new Client();
        try {
            $response = $client->post($this->apiurl, [
                'body' => $json,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode($this->apikey)
                ],
            ]);
            $results = $response->getBody();
        }
        catch (ClientException $ex) {
            $response = $ex->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $results = "ERROR: " . $responseBodyAsString;
        }
        $this->cache->set($key, $results, 60); 
        return $results;       
    }

}