<?php
//echo (serialize(scan_device()));
// $answer = key_2('192.168.100.200', 1);
//echo 'answer - ' . $answer;
//$answer = key_power('192.168.100.200', '1');
//echo 'answer - ' . $answer;

class MAG250 {
// scan device
function scan_device()
    {
    $arr = array(
        'protocol' => 'remote_stb_1.0',
        'port' => 6777
    );
    $post_data = json_encode($arr);

    // create socket
    $sock = socket_create(AF_INET, SOCK_DGRAM, 0);
    socket_set_option($sock, SOL_SOCKET, SO_BROADCAST, 1);
    socket_bind($sock, 0, 6777);
    socket_sendto($sock, $post_data, strlen($post_data) , 0, '239.255.255.250', 6000);
    socket_set_option($sock, SOL_SOCKET, SO_RCVTIMEO, array(
        "sec" => 1,
        "usec" => 10
    ));
    $response = array();
    do {
        $buf = null;
        @socket_recvfrom($sock, $buf, 2048, 0, $host, $sport);
        if (!is_null($buf))
            {
			$response['host'] = $host;
            $response['answer'] = $buf;
            }
        }
    while (!is_null($buf));
    return $response;
    }
// send command to device and wait answer from device 1-ok 0-false
// command must be array
function send_command($ip, $command, $password)
    {
    // create socket
    $sock = socket_create(AF_INET, SOCK_DGRAM, 0);
    socket_set_option($sock, SOL_SOCKET, SO_BROADCAST, 1);
    socket_bind($sock, 0, 6777);
	// befor send command need the check link
	$arr=array('msgType'=>'pingRequest');
    $post_data = json_encode($arr);
    socket_sendto($sock, $post_data, strlen($post_data), 0, $ip, 7666);
	
    // convert array to json
    $command = json_encode($command);
    // coded to aes-256-cbc
    $post_data = $this->encrypt_answer($command, $password);
    // send command
    socket_sendto($sock, $post_data, strlen($post_data) , 0, $ip, 7666);
    socket_set_option($sock, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 1, "usec" => 50));
    // recive command
    do {
        $buf = null;
        @socket_recvfrom($sock, $buf, 2048, 0, $host, $port);
        if (!is_null($buf)) {
            $response =$buf;
			$decript=$this->decrypt_answer($buf,$password);
        }
    } while (!is_null($buf));
    socket_close($sock);
	if ($decript='{"msgType":"pingResponse"}'){
	    return 'ok';
	} else {
        return;
	}
}
// decription text
function decrypt_answer($text, $password)
    {
    $iv = 'erghnlhbnmbnkghy';
    $result = openssl_decrypt($text, 'AES-256-CBC', $password, OPENSSL_RAW_DATA, $iv);
    return $result;
    }
// encription text
function encrypt_answer($text, $password)
    {
    $iv = 'erghnlhbnmbnkghy';
    $result = openssl_encrypt($text, 'AES-256-CBC', $password, OPENSSL_RAW_DATA, $iv);
    return $result;
    }
function key_power($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 134217728,
        "keycode" => 85,
        "unicode" => 117,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_mute($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 134217728,
        "keycode" => 96,
        "unicode" => 96,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_audiomode($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 134217728,
        "keycode" => 71,
        "unicode" => 0,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_setting($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 67108864,
        "keycode" => 16777272,
        "unicode" => 120,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_red($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 67108864,
        "keycode" => 16777264,
        "unicode" => 112,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_green($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 67108864,
        "keycode" => 16777265,
        "unicode" => 113,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_yellow($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 67108864,
        "keycode" => 16777266,
        "unicode" => 114,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_blue($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 67108864,
        "keycode" => 16777267,
        "unicode" => 115,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_menu($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 67108864,
        "keycode" => 16777274,
        "unicode" => 122,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_back($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 0,
        "keycode" => 16777219,
        "unicode" => 8,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_exit($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 0,
        "keycode" => 16777216,
        "unicode" => 27,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_info($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 134217728,
        "keycode" => 89,
        "unicode" => 121,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_app($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 67108864,
        "keycode" => 16777275,
        "unicode" => 123,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_tv($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 67108864,
        "keycode" => 16777273,
        "unicode" => 121,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_guide($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 134217728,
        "keycode" => 67108864,
        "unicode" => 119,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_rew($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 134217728,
        "keycode" => 66,
        "unicode" => 98,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_ffwd($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 134217728,
        "keycode" => 70,
        "unicode" => 102,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_play($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 134217728,
        "keycode" => 82,
        "unicode" => 114,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_stop($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 134217728,
        "keycode" => 83,
        "unicode" => 115,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_size($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 67108864,
        "keycode" => 16777269,
        "unicode" => 11,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_reload($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 0,
        "keycode" => 16777272,
        "unicode" => 116,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_1($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 0,
        "keycode" => 49,
        "unicode" => 1,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_2($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 0,
        "keycode" => 50,
        "unicode" => 2,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_3($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 0,
        "keycode" => 51,
        "unicode" => 3,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_4($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 0,
        "keycode" => 52,
        "unicode" => 4,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_5($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 0,
        "keycode" => 53,
        "unicode" => 5,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_6($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 0,
        "keycode" => 54,
        "unicode" => 6,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_7($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 0,
        "keycode" => 55,
        "unicode" => 7,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_8($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 0,
        "keycode" => 56,
        "unicode" => 8,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_9($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 0,
        "keycode" => 57,
        "unicode" => 9,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_0($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 0,
        "keycode" => 48,
        "unicode" => 0,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_home($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 0,
        "keycode" => 16777216,
        "unicode" => 27,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_ok($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 0,
        "keycode" => 16777220,
        "unicode" => 13,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_volumedown($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 0,
        "keycode" => 45,
        "unicode" => 45,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
function key_volumeup($ip, $password)
    {
    $command = array(
        "msgType" => "keyboardKey",
        "action" => "press",
        "metaState" => 0,
        "keycode" => 43,
        "unicode" => 43,
        "action" => "press"
    );
    $answer = $this->send_command($ip, $command, $password);
    return $answer;
    }
}
