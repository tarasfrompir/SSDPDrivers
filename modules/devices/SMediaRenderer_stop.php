<?php

require(dirname(__FILE__).'/../ssdp_finder/upnp/vendor/autoload.php');

use jalder\Upnp\Renderer;

$renderer = new MediaRenderer();

$adress = $this->getProperty("CONTROLADDRESS");
$stop = $this->getProperty("stop");
$remote = new MediaRenderer\Remote($adress);
if ( $stop ) {
    $result = $remote->stop();
    $this->setProperty("stop",0);
} else {
    $this->setProperty("stop",0);
    }



