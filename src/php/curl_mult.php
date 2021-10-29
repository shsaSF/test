<?php

$urls= array();

$file = new SplFileObject($argv[1]);
while (!$file->eof()) {
   urls[] = "https://" . ($file->fgetcsv())[2]  . "/\n";
}


function getMultiContents($urls) {
    $mh  = curl_multi_init();
    $chs = [];
    $ret = [];
    foreach($urls as $url) {
        $chs[$url] = curl_init($url);
        curl_setopt_array($chs[$url], 
           array(
		CURLOPT_URL            => $url,
		CURLOPT_HEADER         => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_TIMEOUT        => 30
    	   )
        );
        curl_multi_add_handle($mh, $chs[$url]);
    }
    $running = null;
    do { curl_multi_exec($mh, $running); } while ( $running );
    foreach( $urls as $url ) {
        $ret[$url] = curl_multi_getcontent($chs[$url]);
        curl_multi_remove_handle($mh, $chs[$url]);
        curl_close($chs[$url]);
    }
    curl_multi_close($mh);
    return $ret;
}


$ret = getMultiContents($urls);
foreach ($ret as $url => $value) {
    echo $value.'<br>';
}

?>

