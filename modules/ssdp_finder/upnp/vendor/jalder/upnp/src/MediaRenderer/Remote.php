<?php
/** AVTransport UPnP Class
 * Used for controlling renderers
 *
 * @author jalder
 */

namespace jalder\Upnp\MediaRenderer;

use jalder\Upnp;

class Remote {

  public $ctrlurl;
  private $upnp;
  public $service_type;
  public function __construct($server) {
    $control_url = str_ireplace("Location:", "", $server);
    $url = parse_url($control_url);
    $this->ip = $url['host'];
    $this->port = $url['port'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $control_url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $content = curl_exec($ch);
    libxml_use_internal_errors(true); 
    $xml = simplexml_load_string($content);
	   
    foreach($xml->device->serviceList->service as $service){
          if($service->serviceId == 'urn:upnp-org:serviceId:AVTransport'){
                $chek_url = (substr($service->controlURL,0,1));
                $this->service_type = ($service->serviceType);
                if ($chek_url == '/') {
                   $this->ctrlurl = ($url['scheme'].'://'.$url['host'].':'.$url['port'].$service->controlURL);
		   echo ($this->ctrlurl);
                } else {
                    $this->ctrlurl = ($url['scheme'].'://'.$url['host'].':'.$url['port'].'/'.$service->controlURL);
			echo ($this->ctrlurl);
                }
          }
    }
}


    public function setNext($url)
	{
		$args = array(
			'InstanceID'=>0,
			'NextURI'=>'<![CDATA['.$url.']]>',
			'NextURIMetaData'=>'testmetadata'
		);
		return $this->sendRequestToDevice('SetNextAVTransportURI',$args,$this->ctrlurl,$this->service_type);
	}
	//this should be moved to the upnp and renderer model
	public function getControlURL($description_url, $service = 'AVTransport') {
		$description = $this->getDescription($description_url);
                foreach($description['device']['serviceList']['service'] as $service) {
  			if($service['serviceType'] == $this->service_type) {
				$url = parse_url($description_url);
				return $url['scheme'].'://'.$url['host'].':'.$url['port'].$service['controlURL'];
			}
		}
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
		// сохраняет данные в файл
		//$file = 'people.txt';
                //file_put_contents($file, $response);
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
	    $tags = get_meta_tags($url);
	    $args = array('InstanceID'=>0, 'CurrentURI'=>'<![CDATA['.$url.']]>', 'CurrentURIMetaData'=>''); //$tags['author']  
	    $response = $this->sendRequestToDevice('SetAVTransportURI',$args,$this->ctrlurl,$this->service_type);
            $args = array('InstanceID'=>0,'Speed'=>1);
	    $this->sendRequestToDevice('Play',$args,$this->ctrlurl,$this->service_type);
	    return $response;
	}
	
        private function sendRequestToDevice($method, $arguments, $url, $type) {
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
        echo ('method '.$method);
        var_dump ('ST '.$this->service_type);
	$header = array(
	    'Host: '.$this->ip.':'.$this->port,
            'User-Agent: '.$this->user_agent, //fudge the user agent to get desired video format
            'Content-Length: ' . strlen($body),
	    'Connection: close',
            'Content-Type: text/xml; charset="utf-8"',
	    'SOAPAction: "'.$this->service_type.'#'.$method.'"',
             );
        var_dump ($header);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_POST, TRUE );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $body );
        $response = curl_exec( $ch );
        curl_close( $ch );
        $doc = new \DOMDocument();
        $doc->loadXML($response);
        $result = $doc->getElementsByTagName('Result');
	
        if(is_object($result->item(0))){
            echo ( $result->item(0)->nodeValue);
            return $result->item(0)->nodeValue;
        }
        return $response;
    }
}
