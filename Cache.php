<?php


class Cache
{
    public function saveCache()
    {
        $timeout = 600000;

        $url = $_SERVER['API_ENDPOINT'];
        $name = explode('/', $url);
        $file = $name[count($name) -1];
        $cache = 'cachefile-'.substr_replace($file,"",-4).'.html';

        if(!empty($_REQUEST['CACHE_TIME'])){
            $timeout = $_REQUEST['CACHE_TIME'];
        }

        if(file_exists($cache) && time() - $timeout < filemtime($cache)){
            echo "<!-- Cache generated ".date('H:i', filemtime($cache))." -->\n";
            readfile($cache);
            exit;
        }

        ob_start();
    }

}