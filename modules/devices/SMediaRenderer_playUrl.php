<?php
require(dirname(__FILE__).'/../ssdp_finder/upnp/vendor/autoload.php');
use jalder\Upnp\MediaRenderer;
$renderer = new MediaRenderer();

$adress = $this->getProperty("CONTROLADDRESS");
$remote = new MediaRenderer\Remote($adress);

$playUrl = $this->getProperty("playUrl");
$services = $this->getProperty("Services");

$info = $remote->getPosition();
$doc = new \DOMDocument();
$doc->loadXML($info);
$result = $doc->getElementsByTagName('Track');
$trackn = $result->item(0)->nodeValue;
DebMes ($trackn);       
$result = $doc->getElementsByTagName('TrackURI');
$trackurl = $result->item(0)->nodeValue;
DebMes($trackurl); 
$result = $doc->getElementsByTagName('RelTime');
$tracktime = $result->item(0)->nodeValue;
DebMes($tracktime); 
DebMes($playUrl); 
DebMes($adress); 
$result = $remote->stop();
$result = $remote->play($playUrl);
DebMes($result);
