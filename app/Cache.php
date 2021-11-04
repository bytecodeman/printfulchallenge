<?php

declare(strict_types=1);

namespace Homework;

include("interfaces\CacheInterface.php");

class Cache implements CacheInterface {

    private $cacheFilename = "cachefile.txt";

    private function getCacheData() {
        if (($data = @file_get_contents($this->cacheFilename)) === false) {
            $data = "";
        }
        return $data;        
    }
    
    public function __construct() {

    }

    public function set(string $key, $value, int $duration) {
        $data = $this->getCacheData();
        $pattern = preg_quote($key, '/');
        $pattern = "/^($pattern):.*(?:\n)/m";
        $data = preg_replace($pattern, "", $data);
        $data .= $key . ":" . strval((time() + $duration)) . ":" . $value . "\n";
        file_put_contents($this->cacheFilename, $data);
    }

    public function get(string $key) {
        $data = $this->getCacheData();
        $pattern = preg_quote($key, '/');
        $pattern = "/^($pattern):(\d*):(.*)\$/m";
        if (preg_match_all($pattern, $data, $matches) > 0) {
            if (time() > $matches[2][0])
                return "";
            return $matches[3][0];
        }
        return "";
    }
}