<?php

require(dirname(__FILE__).'/../ssdp_finder/upnp/vendor/autoload.php');

use jalder\Upnp\MediaRenderer;

$renderer = new MediaRenderer();

$adress = $this->getProperty("CONTROLADDRESS");
$remote = new MediaRenderer\Remote($adress);
$next = $this->getProperty("next");
if ( $next ) {
    $result = $remote->next();
    $this->setProperty("next",0);
} else {
    $this->setProperty("next",0);
}