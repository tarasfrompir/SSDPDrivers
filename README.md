# SSDPDrivers
необходимые файлы для модуля ССДП Финдер

Nedded drivers for SSDPFinder

sayTo("Пробны варинат дло длоыв ыжвщл авжлждвыл ждуцл жцулзщуц зщшла зуцлжывлсвж ывждлывж длауцзщш зуцш азщуцла джвыла узцшу заушц важдвыл ждл выл ",1,'MediaRenderer01');

                if ($source_event == 'ASK') {
                    $details['level']=9999;
                }
		  $this->set_cherga($terminal_rec,$details['level'],$filename);
                $this->terminalSayByCache($terminal_rec, $filename, $details['level']);

/**
* очередь сообщений 
*
* @access public
*/
function set_cherga($target, $levelMes, $cached_filename) { 

   // berem vse soobsheniya po urovnyu
   $l_level_mesage = SQLSelect("SELECT * FROM jobs WHERE TITLE LIKE'".'sayTo-timers-'.$target['TITLE'].'-level-'.$levelMes.'-number-'."%' ORDER BY `TITLE`");

   ///  last mesage for levelmes
   $last_mesage = max(array_column($l_level_mesage,'TITLE'));

   // opredelyaem posledniy nomer soobsheniya esli ih netu to poluchim #001
   $pos = strripos($last_mesage, '-');
   $last_number = substr($last_mesage, $pos+1)+1;
   if ($last_number<1 ){
      $last_number='001';
    } else if ($last_number<10 ) {
      $last_number='00'.$last_number;
    } else {
      $last_number='0'.$last_number;
    }

    // poluchaem adress cashed files dlya zapuska ego na vosproizvedeniye
    if (preg_match('/\/cms\/cached.+/',$cached_filename,$m)) {
        $server_ip = $this->getLocalIp();
        if (!$server_ip) {
            DebMes("Server IP not found", 'terminals');
            return false;
        } else {
            $cached_filename='http://'.$server_ip.$m[0];
        }
    } else {
        DebMes("Unknown file path format: " . $cached_filename, 'terminals');
        return false;
    }
 
    // esli net soobsheniy dlya takogo urovnya to sozdaem pervoe s takim urovnem
    if (!$last_mesage) {
       $time_shift = 30;
       DebMes('create first mesage');
       addScheduledJob('sayTo-timers-'.$target['TITLE'].'-level-'.$levelMes.'-number-'.$last_number, "playMedia('".$cached_filename."', '".$target['TITLE']."');", time()+1, $time_shift);
    } else {
    // esli soobsheniya sushestvuyut to vstavlayem svoe poslednim po spisku s uchetom urovnya soobsheniya
        $time_shift = 30;
        DebMes('add new message'.$last_mesage);
        addScheduledJob('sayTo-timers-'.$target['TITLE'].'-level-'.$levelMes.'-number-'.$last_number, "playMedia('".$cached_filename."', '".$target['TITLE']."');", time()+1000, $time_shift);
    }

    // vibiraem vse soobsheniya dla terminala s sortirovkoy po nazvaniyu
    $all_messages = SQLSelect("SELECT * FROM jobs WHERE TITLE LIKE'".'sayTo-timers-'.$target['TITLE'].'-level-'.'%-number-'."%' ORDER BY `TITLE`");
    $runtime = time()+1;
    foreach ($all_messages as $message) {
      $expire = (strtotime($message['EXPIRE']))-(strtotime($message['RUNTIME']));
      $rec['ID']       = $message['ID'];
      $rec['TITLE']    = $message['TITLE'];
      $rec['COMMANDS'] = $message['COMMANDS'];
      $rec['RUNTIME']  = date('Y-m-d H:i:s', $runtime);
      $rec['EXPIRE']   = date('Y-m-d H:i:s', $runtime+$expire);
      $runtime = $runtime + $expire;
      
      //$rec['RUNTIME']  = date('Y-m-d H:i:s', (strtotime($message['RUNTIME'])));
      //$rec['EXPIRE']   = date('Y-m-d H:i:s', (strtotime($message['EXPIRE'])));
      SQLUpdate('jobs', $rec);
     }
   }
