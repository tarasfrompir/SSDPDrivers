<?php
require(dirname(__FILE__).'/../ssdp_finder/upnp/vendor/autoload.php');
use jalder\Upnp\BelkinDevice;
$BelkinDevice= new BelkinDevice();
$adress = $this->getProperty("CONTROLADDRESS");
$status = $this->getProperty("turnOn");
$remote = new BelkinDevice\Devswitch($adress);
$result = $remote->on();
if ($result) {
    $this->setProperty('status', 1);
    } else {
    $this->setProperty('status', 0);
    $this->setProperty('alive', 0);
    say ("Выключатель ".$this->object_title." размещенный в комнате ".$this->getProperty("linkedRoom")." не сработал!", 2);
};
