<?php
require(dirname(__FILE__).'/../ssdp_finder/upnp/vendor/autoload.php');
use jalder\Upnp\MediaRenderer;
$renderer = new MediaRenderer();

$adress = $this->getProperty("CONTROLADDRESS");
$remote = new MediaRenderer\Remote($adress);
echo ($remote);
$playUrl = $this->getProperty("playUrl");
$services = $this->getProperty("Services");

$info = $remote->getPosition();
$doc = new \DOMDocument();
$doc->loadXML($info);
$result = $doc->getElementsByTagName('Track');
$trackn = $result->item(0)->nodeValue;
echo ($trackn);       
$result = $doc->getElementsByTagName('TrackURI');
$trackurl = $result->item(0)->nodeValue;
echo($trackurl); 
$result = $doc->getElementsByTagName('RelTime');
$tracktime = $result->item(0)->nodeValue;
echo ($tracktime); 
echo ($playUrl); 
echo ($adress); 
$result = $remote->stop();
$result = $remote->play($playUrl);
echo ($result);
