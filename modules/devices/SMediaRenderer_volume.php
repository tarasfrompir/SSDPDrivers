<?php

require(dirname(__FILE__).'/../ssdp_finder/upnp/vendor/autoload.php');

use jalder\Upnp\MediaRenderer;

$adress = $this->getProperty("CONTROLADDRESS");
$remote = new MediaRenderer\Remote1($adress);
$volume = $this->getProperty("volume");
$result = $remote->SetVolume($volume);
