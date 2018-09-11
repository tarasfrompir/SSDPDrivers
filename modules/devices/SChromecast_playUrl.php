<?
require_once("dirname(__FILE__).'/../ssdp_finder/upnp/vendor/jalder/upnp/src/Chromecast/Remote.php");

$adress = $this->getProperty("CONTROLADDRESS");
$ip = getIp($adress,false)
$playUrl = $this->getProperty("playUrl");



// Create Chromecast object and give IP and Port
$cc = new Chromecast($ip,"8009");

$cc->DMP->play($playUrl,"BUFFERED","video/mp4",true,0);
//$cc->DMP->UnMute();
//$cc->DMP->SetVolume(1);
//sleep(5);
//$cc->DMP->pause();
//print_r($cc->DMP->getStatus());
//sleep(5);
//$cc->DMP->restart();
//sleep(5);
//$cc->DMP->seek(100);
//sleep(5);
//$cc->DMP->SetVolume(0.5);
//sleep(15);
//$cc->DMP->SetVolume(1); // Turn the volume back up
//$cc->DMP->Mute();
//sleep(20);
//$cc->DMP->UnMute();
//sleep(5);
//$cc->DMP->Stop();

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