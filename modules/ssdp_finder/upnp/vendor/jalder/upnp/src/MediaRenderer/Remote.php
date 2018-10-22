<?php
/** AVTransport UPnP Class
 * Used for controlling renderers
 *
 * @author jalder
 */

namespace jalder\Upnp\MediaRenderer;
use jalder\Upnp;

class Remote {
    public

    function __construct($server) {
        $crl = str_ireplace("Location:", "", $server);

        // получаем айпи и порт устройства
        $url = parse_url($crl);
        $this->ip = $url['host'];
        $this->port = $url['port'];

        // получаем XML
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $crl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($ch);
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($content);

        // получаем адрес управления устройством
        foreach($xml->device->serviceList->service as $service) {
            if ($service->serviceId == 'urn:upnp-org:serviceId:AVTransport') {
                $chek_url = (substr($service->controlURL, 0, 1));
                $this->service_type = ($service->serviceType);
                if ($chek_url == '/') {
                    $this->ctrlurl = ($url['scheme'] . '://' . $url['host'] . ':' . $url['port'] . $service->controlURL);
                } else {
                    $this->ctrlurl = ($url['scheme'] . '://' . $url['host'] . ':' . $url['port'] . '/' . $service->controlURL);
                }
            }
        }
    }

    private function instanceOnly($command, $id = 0) {
        $args = array('InstanceID' => $id);
        return $this->sendRequestToDevice($command, $args);
    }

    private function sendRequestToDevice($command, $arguments) {
        $body = '<?xml version="1.0" encoding="utf-8"?>' . "\r\n";
        $body.= '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/" s:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">';
        $body.= '<s:Body>';
        $body.= '<u:' . $command . ' xmlns:u="' . $this->service_type . '">';
        foreach($arguments as $arg => $value) {
            $body.= '<' . $arg . '>' . $value . '</' . $arg . '>';
        }

        $body.= '</u:' . $command . '>';
        $body.= '</s:Body>';
        $body.= '</s:Envelope>';
        $header = array(
            'Host: ' . $this->ip . ':' . $this->port,
            'User-Agent: ' . $this->user_agent, //fudge the user agent to get desired video format
            'Content-Length: ' . strlen($body) ,
            'Connection: close',
            'Content-Type: text/xml; charset="utf-8"',
            'SOAPAction: "' . $this->service_type . '#' . $command . '"',
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $this->ctrlurl);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        $response = curl_exec($ch);
        curl_close($ch);
        // создает документ хмл
        $doc = new \DOMDocument();
        //  загружет его
        $doc->loadXML($response);
        //  выбирает поле соответсвтуещее
        $result = $doc->getElementsByTagName($command.'Response');
        if(is_object($result->item(0))){
          return $command.' ok';
        }
        
        return $result;
    }

    public function play($url = "") {
        if ($url === "") {
            return self::unpause();
        }
		$id = mt_rand(1, 999999); 
        $meta = '<DIDL-Lite xmlns="urn:schemas-upnp-org:metadata-1-0/DIDL-Lite/" xmlns:upnp="urn:schemas-upnp-org:metadata-1-0/upnp/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dlna=”urn:schemas-dlna-org:metadata-1-0" xmlns:sec="http://www.sec.co.kr/" xmlns:pv="http://www.pw.com/pvns">
                  <item id="'.$id.'" parentID="0" restricted="0">
                   <upnp:class>object.item.videoItem</upnp:class>
                   <dc:title>Majordomo message</dc:title>
                   <dc:creator>Majordomo</dc:creator>
                   <upnp:artist>Tarasfrompir</upnp:artist>
                   <res protocolInfo="http-get:*:'.get_headers($url, 1)["Content-Type"].':DLNA.ORG_PN='.substr(get_headers($url, 1)["Content-Disposition"],-3).';DLNA.ORG_OP=01;DLNA.ORG_CI=0;DLNA.ORG_FLAGS=01700000000000000000000000000000" size="'.get_headers($url, 1)["Content-Length"].'" duration="0:03:57.000" bitrate="4000">'.$playUrl.'</res>
                  </item>
                 </DIDL-Lite>';
        $args = array('InstanceID' => '0', 'CurrentURI' => '<![CDATA[' . $url . ']]>', 'CurrentURIMetaData' => $meta);
        $response = $this->sendRequestToDevice('SetAVTransportURI', $args);
        //var_dump($response);
        $args = array( 'InstanceID' => 0, 'Speed' => 1);
        $response = $this->sendRequestToDevice('Play', $args);
	//var_dump($response);
        return $response;
    }

    public function seek($unit = 'TRACK_NR', $target = 0) {
        $response = $this->sendRequestToDevice('Seek', $args);
        return $response['s:Body']['u:SeekResponse'];
    }

    public function setNext($url) {
        $tags = get_meta_tags($url);
        $args = array(
            'InstanceID' => 0,
            'NextURI' => '<![CDATA[' . $url . ']]>',
            'NextURIMetaData' => ''
        );
        return $this->sendRequestToDevice('SetNextAVTransportURI', $args);
    }

    public function getState() {
        return $this->instanceOnly('GetTransportInfo');
    }

    public function getPosition() {
        return $this->instanceOnly('getPositionInfo');
    }

    public function getMedia() {
        $response = $this->instanceOnly('GetMediaInfo');

        // создает документ хмл
        $doc = new \DOMDocument();
        //  загружет его
        $doc->loadXML($response);
        //  выбирает поле соответсвтуещее
        $result = $doc->getElementsByTagName('CurrentURI');
        foreach($result as $item) {
            $track = $item->nodeValue;
        }

        return $track;
    }

    public function stop() {
        return $this->instanceOnly('Stop');
    }

    public function unpause() {
        $args = array(
            'InstanceID' => 0,
            'Speed' => 1
        );
        return $this->sendRequestToDevice('Play', $args);
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
    
}
