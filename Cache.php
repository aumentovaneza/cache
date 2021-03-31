<?php


class Cache
{
    public function saveCache()
    {
        // Declare
        $timeout = 600000;
        $url = $_SERVER['API_ENDPOINT'];
        $name = explode('/', $url);
        $file = $name[count($name) -1];
        $cache = 'cachefile-'.substr_replace($file,"",-4).'.html';

        //check if there is a set cache time, if not use default
        if(!empty($_REQUEST['CACHE_TIME'])){
            $timeout = $_REQUEST['CACHE_TIME'];
        }

        //Execute
        if(file_exists($cache) && time() - $timeout < filemtime($cache)){
            echo "<!-- Cache generated for endpoint".date('H:i', filemtime($cache))." -->\n";
            readfile($cache);
            exit;
        }

        ob_start();
    }

}