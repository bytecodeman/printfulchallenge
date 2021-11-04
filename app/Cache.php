<?php
// Tony Silvestri
// 11/4/21

declare(strict_types=1);

namespace Homework;

include("interfaces\CacheInterface.php");

class Cache implements CacheInterface {

    private $cacheFilename = "cachefile.txt";

    private function file_get_contents_locking($filename) {
        $file = fopen($filename, 'rb');
        if ($file === false) {
            return false;
        }
        $lock = flock($file, LOCK_SH);
        if (!$lock) {
            fclose($file);
            return false;
        }
        $string = '';
        while (!feof($file)) {
            $string .= fread($file, 8192);
        }
        flock($file, LOCK_UN);
        fclose($file);
        return $string;
    }

    private function getCacheData() {
        if (($data = $this->file_get_contents_locking($this->cacheFilename)) === false) {
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
        file_put_contents($this->cacheFilename, $data, LOCK_EX);
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