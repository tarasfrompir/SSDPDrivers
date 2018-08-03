<?php

require(dirname(__FILE__).'/../ssdp_finder/upnp/vendor/autoload.php');

use jalder\Upnp\MediaRenderer;

$adress = $this->getProperty("CONTROLADDRESS");
$remote = new MediaRenderer\Remote($adress);
$mute_unmute = $this->getProperty("mute_unmute");
if ( $mute_unmute ) {
            $result = $remote->mute();
		} else {
            $result = $remote->unmute();
        }
