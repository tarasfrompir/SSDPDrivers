<?php 
require_once (dirname(__FILE__) . "/../ssdp_finder/upnp/vendor/jalder/upnp/src/Chromecast/Remote.php");

$adress = $this->getProperty("ADDRESS");
$port = $this->getProperty("MODEL");
$ip = getIp($adress, false);
$playUrl = $this->getProperty("playUrl");
echo ($ip);

// Create Chromecast object and give IP and Port

$cc = new Chromecast($adress, $port);

if (preg_match('/\.mp3/', $playUrl))
    {
    $content_type = 'audio/mp3';
    }
elseif (preg_match('/mp4/', $playUrl))
    {
    $content_type = 'video/mp4';
    }
elseif (preg_match('/m4a/', $playUrl))
    {
    $content_type = 'audio/mp4';
    }
elseif (preg_match('/^http/', $playUrl))
    {
    $content_type = '';
    if ($fp = fopen($playUrl, 'r'))
        {
        $meta = stream_get_meta_data($fp);
        if (is_array($meta['wrapper_data']))
            {
            $items = $meta['wrapper_data'];
            foreach($items as $line)
                {
                if (preg_match('/Content-Type:(.+)/is', $line, $m))
                    {
                    $content_type = trim($m[1]);
                    }
                }
            }

        fclose($fp);
        }
    }

if (!$content_type)
    {
    $content_type = 'audio/mpeg';
    }

$cc->DMP->play($playUrl, 'LIVE', $content_type, true, 0);

function getIp($baseUrl, $withPort)
    {
    if (!empty($baseUrl))
        {
        $parsed_url = parse_url($baseUrl);
        if ($withPort == true)
            {
            $baseUrl = $parsed_url['scheme'] . '://' . $parsed_url['host'] . ':' . $parsed_url['port'];
            }
          else
            {
            $baseUrl = $parsed_url['host'];
            }
        }

    return $baseUrl;
    }
