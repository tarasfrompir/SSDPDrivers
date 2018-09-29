<?
require_once(dirname(__FILE__)."/../ssdp_finder/upnp/vendor/jalder/upnp/src/MagXXXdevice/Remote.php");
$adress = $this->getProperty("CONTROLADDRESS");
$password = $this->getProperty("PASSWORD");

// Create Chromecast object and give IP and Port
$mag = new MAG250();
$mag->key_yellou($adress, $password);
$this->setProperty("F3",0);