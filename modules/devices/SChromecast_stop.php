<?
require_once(dirname(__FILE__)."/../ssdp_finder/upnp/vendor/jalder/upnp/src/Chromecast/Remote.php");

$adress = $this->getProperty("CONTROLADDRESS");
$port = getport($adress);
$ip = getIp($adress, false);
// Create Chromecast object and give IP and Port
$cc = new Chromecast($ip, $port);

$cc->DMP->Stop();

function getIp($baseUrl, $withPort)
    {
    if (!empty($baseUrl))
        {
        $parsed_url = parse_url($baseUrl);
        if ($withPort == true)
            {
            $baseUrl = $parsed_url['scheme'] . '://' . $parsed_url['host'] . ':' . $parsed_url['port'];
            }
          else
            {
            $baseUrl = $parsed_url['host'];
            }
        }
    return $baseUrl;
    }
/**
* get port from url
*
* @access public
*/
 function getPort($address){
  $baseUrl="";
	if( !empty($address) ){
        $parsed_url = parse_url($address);
        $baseUrl = $parsed_url['port'];
        }
    return  $baseUrl;
}
