<?php
require(dirname(__FILE__).'/../ssdp_finder/upnp/vendor/autoload.php');
use jalder\Upnp\MediaRenderer;
$renderer = new MediaRenderer();

$adress = $this->getProperty("CONTROLADDRESS");
$remote = new MediaRenderer\Remote($adress);
$playUrl = $this->getProperty("playUrl");
echo ($remote->getState());
$result = $remote->stop();
$result = $remote->play($playUrl);
echo('Result - '.$result);
