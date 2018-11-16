# SSDPDrivers
необходимые файлы для модуля ССДП Финдер

Nedded drivers for SSDPFinder




/**
 * Summary of playMedia
 * @param mixed $path Path
 * @param mixed $host Host (default 'localhost')
 * @return int
 */
function getmedia_terminal ($host = 'localhost') {
    if(!$terminal = getTerminalsByName($host, 1)[0]) {
		$terminal = getTerminalsByHost($host, 1)[0];
	}
	//DebMes($terminal);
	DebMes($terminal['PLAYER_TYPE']);
	DebMes($terminal['TITLE']);
    include_once(DIR_MODULES . 'app_player/addons.php');
    include_once(DIR_MODULES . 'app_player/addons/'.$terminal['PLAYER_TYPE'].'.addon.php');
	
    $terminal = new $terminal['PLAYER_TYPE']($terminal);
    DebMes( $terminal->status());
    return $terminal->status();
}
