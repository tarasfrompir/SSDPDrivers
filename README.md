# SSDPDrivers
необходимые файлы для модуля ССДП Финдер

Nedded drivers for SSDPFinder




/**
 * Summary of player status 
 * @param mixed $host Host (default 'localhost') name or ip of terminal
 * @return  'track_id'        => (int)$track_id, //ID of currently playing track (in playlist). Integer. If unknown (playback stopped or playlist is empty) = -1.
 *          'length'          => (int)$length, //Track length in seconds. Integer. If unknown = 0. 
 *          'time'            => (int)$time, //Current playback progress (in seconds). If unknown = 0. 
 *          'state'           => (string)$state, //Playback status. String: stopped/playing/paused/unknown 
 *          'volume'          => (int)$volume, // Volume level in percent. Integer. Some players may have values greater than 100.
 *          'random'          => (boolean)$random, // Random mode. Boolean. 
 *          'loop'            => (boolean)$loop, // Loop mode. Boolean.
 *          'repeat'          => (boolean)$repeat, //Repeat mode. Boolean.
 *          'speed'           => (float)$current_speed, //Current speed for playing media. float.
 *          'link'            => (string)$curren_url, //Current link for media in device. String.
 */
function getPlayerStatus ($host = 'localhost') {
    if(!$terminal = getTerminalsByName($host, 1)[0]) {
	$terminal = getTerminalsByHost($host, 1)[0];
	}
    if(!$terminal) {
	return;
	}
    include_once(DIR_MODULES . 'app_player/addons.php');
    include_once(DIR_MODULES . 'app_player/addons/'.$terminal['PLAYER_TYPE'].'.addon.php');	
    $player = new $terminal['PLAYER_TYPE']($terminal);
    //DebMes( $player->status());
    return $player->status();
}
