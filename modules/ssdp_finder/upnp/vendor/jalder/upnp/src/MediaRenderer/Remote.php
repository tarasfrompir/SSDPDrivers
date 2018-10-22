<?php
/** AVTransport UPnP Class
 * Used for controlling renderers
 *
 * @author jalder
 */

namespace jalder\Upnp\MediaRenderer;

use jalder\Upnp;

class Remote {

  public function __construct($server) {
    $crl = str_ireplace("Location:", "", $server);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $crl);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $content = curl_exec($ch);
    libxml_use_internal_errors(true); 
    $xml = simplexml_load_string($content);
    
	$url = parse_url($crl);
    $this->ip = $url['host'];
    $this->port = $url['port'];
    foreach($xml->device->serviceList->service as $service){
          if($service->serviceId == 'urn:upnp-org:serviceId:AVTransport'){
                $chek_url = (substr($service->controlURL,0,1));
                $this->service_type = ($service->serviceType);
                if ($chek_url == '/') {
                   $this->ctrlurl = ($url['scheme'].'://'.$url['host'].':'.$url['port'].$service->controlURL);
                } else {
                    $this->ctrlurl = ($url['scheme'].'://'.$url['host'].':'.$url['port'].'/'.$service->controlURL);
                }
          }
    }
}

public function setNext($url) {
  $tags = get_meta_tags($url);
  $args = array(
            'InstanceID'=>0,
            'NextURI'=>'<![CDATA['.$url.']]>',
            'NextURIMetaData'=>'testmetadata'
            );
   return $this->sendRequestToDevice('SetNextAVTransportURI',$args,$this->ctrlurl,$this->service_type);
   }

  public function getState() {
    return $this->instanceOnly('GetTransportInfo');
  }

 public function getPosition() {
     return $this->instanceOnly('getPositionInfo');
     }

    private function instanceOnly($command,$type = 'AVTransport', $id = 0) {
        $args = array('InstanceID'=>$id);
        $response = $this->sendRequestToDevice($command,$args,$this->ctrlurl,$this->service_type);
        return $response;
    }

    public function getMedia() {
        $response = $this->instanceOnly('GetMediaInfo');
        // создает документ хмл
        $doc = new \DOMDocument();
        //  загружет его
        $doc->loadXML($response);
        //  выбирает поле соответсвтуещее
        $result = $doc->getElementsByTagName('CurrentURI');
        foreach ($result as $item) {
            $track = $item->nodeValue;
            }
        return $track;
    }
    public function stop() {
        return $this->instanceOnly('Stop');
    }
    
    public function unpause() {
        $args = array('InstanceID'=>0,'Speed'=>1);
        return $this->sendRequestToDevice('Play',$args,$this->ctrlurl,$this->service_type);     
    }

    public function pause() {
        return $this->instanceOnly('Pause');
    }

    public function next() {
        return $this->instanceOnly('Next');
    }

    public function previous() {
        return $this->instanceOnly('Previous');
    }

        public function fforward() {
               return $this->next();
        }

        public function rewind() {
               return $this->previous();
        }

    public function seek($unit = 'TRACK_NR', $target=0) {
        $response = $this->sendRequestToDevice('Seek',$args,$this->ctrlurl.'serviceControl/AVTransport','AVTransport');
        return $response['s:Body']['u:SeekResponse'];
    }
    
    public function play($url = "") {
            if($url === "") {
                return self::unpause();
                }
        $args = array('InstanceID'=>0, 'CurrentURI'=>'<![CDATA['.$url.']]>', 'CurrentURIMetaData'=>'');  
        $response = $this->sendRequestToDevice('SetAVTransportURI',$args,$this->ctrlurl,$this->service_type);
        $args = array('InstanceID'=>0,'Speed'=>1);
        $this->sendRequestToDevice('Play',$args,$this->ctrlurl,$this->service_type);
        return $response;
    }
    
private function sendRequestToDevice($method, $arguments) {
    $body  ='<?xml version="1.0" encoding="utf-8"?>' . "\r\n";
    $body .='<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/" s:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">';
    $body .='<s:Body>';
    $body .='<u:'.$method.' xmlns:u="'.$this->service_type.'">';
    foreach( $arguments as $arg=>$value ) {
        $body .='<'.$arg.'>'.$value.'</'.$arg.'>';
    }
    $body .='</u:'.$method.'>';
    $body .='</s:Body>';
    $body .='</s:Envelope>';
    $header = array(
        'Host: '.$this->ip.':'.$this->port,
        'User-Agent: '.$this->user_agent, //fudge the user agent to get desired video format
        'Content-Length: ' . strlen($body),
        'Connection: close',
        'Content-Type: text/xml; charset="utf-8"',
        'SOAPAction: "'.$this->service_type.'#'.$method.'"',
        );
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
    curl_setopt( $ch, CURLOPT_URL, $this->ctrlurl );
    curl_setopt( $ch, CURLOPT_POST, TRUE );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $body );
    $response = curl_exec( $ch );
	DebMes($response);
    curl_close( $ch );
    $doc = new \DOMDocument();
    $doc->loadXML($response);
    $result = $doc->getElementsByTagName('Result');
    if(is_object($result->item(0))){
        return $result->item(0)->nodeValue;
    }
    return $response;
}
}
