<?php

declare(strict_types=1);

namespace Homework;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Application
{
    private $apiurl = "https://api.printful.com/shipping/rates";
    private $apikey = "77qn9aax-qrrm-idki:lnh0-fm2nhmp0yca7";

    private function convertPOST2JSON($array) {
        return json_encode($array);
    }

    public function run(): void
    {
        $results = null;
        if (!empty($_POST)) {
            $json = $this->convertPOST2JSON($_POST);
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
        }
        echo $this->renderView('views/form.php', ['results' => $results]);
   }

    public function renderView(string $filePath, array $variables = []): string
    {
        ob_start();
        extract($variables, EXTR_OVERWRITE);
        include($filePath);

        return ob_get_clean();
    }
}
