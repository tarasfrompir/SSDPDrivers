<?php
/** AVTransport UPnP Class
 * Used for controlling renderers
 *
 * @author jalder
 */

namespace jalder\Upnp\BinaryLight;

use jalder\Upnp;

class Remote
{


  public $ctrlurl;
  private $upnp;
  public function __construct($server) {
    $this->upnp = new Upnp\Core();
    $control_url = str_ireplace("Location:", "", $server);
    $xml=simplexml_load_file($control_url);
    foreach($xml->device->serviceList->service as $service){
          if($service->serviceId == 'urn:upnp-org:serviceId:SwitchPower:1'){
                $chek_url = (substr($service->controlURL,0,1));
                if ($chek_url == '/') {
                   $this->ctrlurl = ($this->upnp->baseUrl($control_url,True).$service->controlURL);
                 } else {
                    $this->ctrlurl = ($this->upnp->baseUrl($control_url,True).'/'.$service->controlURL);
                }
          }
         }
 }

	

	public function off()
	{
		$args = array('BinaryState'=>0);
		return $this->upnp->sendRequestToDevice('SetBinaryStateResponse',$args,$this->ctrlurl,$type = 'SwitchPower');
	}

	public function on()
	{
		$args = array('BinaryState'=>1);
		return $this->upnp->sendRequestToDevice('SetBinaryStateResponse',$args,$this->ctrlurl,$type = 'SwitchPower');
	}
}
