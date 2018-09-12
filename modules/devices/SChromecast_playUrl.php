<?
require_once(dirname(__FILE__)."/../ssdp_finder/upnp/vendor/jalder/upnp/src/Chromecast/Remote.php");

$adress = $this->getProperty("CONTROLADDRESS");
$ip = getIp($adress,false);
$playUrl = $this->getProperty("playUrl");

echo ($ip);

// Create Chromecast object and give IP and Port
$cc = new Chromecast($ip,"8009");

$cc->DMP->play($playUrl,"BUFFERED","video/mp4",true,0);


function getIp($baseUrl,$withPort) {
	if( !empty($baseUrl) ){
        $parsed_url = parse_url($baseUrl);
        if($withPort ==true){
            $baseUrl = $parsed_url['scheme'].'://'.$parsed_url['host'].':'.$parsed_url['port']; 
           }else{
            $baseUrl = $parsed_url['host'];
        }
    }
    return  $baseUrl;
}