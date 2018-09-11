<?
require_once("dirname(__FILE__).'/../ssdp_finder/upnp/vendor/jalder/upnp/src/Chromecast/Remote.php");

$adress = $this->getProperty("CONTROLADDRESS");
$ip = getIp($adress,false)
$playUrl = $this->getProperty("playUrl");



// Create Chromecast object and give IP and Port
$cc = new Chromecast($ip,"8009");
$cc->DMP->Mute();
$cc->DMP->UnMute();
sleep(5);
$cc->DMP->UnMute();

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