<?php
require(dirname(__FILE__).'/../ssdp_finder/upnp/vendor/autoload.php');

use jalder\Upnp\MediaRenderer;

$renderer = new MediaRenderer();

$adress = $this->getProperty("CONTROLADDRESS");
$remote = new MediaRenderer\Remote($adress);
$pause = $this->getProperty("pause_unpause");
if ( $pause ) {
    $result = $remote->pause();
} else {
    $result = $remote->unpause();
}