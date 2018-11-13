# SSDPDrivers
необходимые файлы для модуля ССДП Финдер

Nedded drivers for SSDPFinder

sayTo("Пробны варинат дло длоыв ыжвщл авжлждвыл ждуцл жцулзщуц зщшла зуцлжывлсвж ывждлывж длауцзщш зуцш азщуцла джвыла узцшу заушц важдвыл ждл выл ",1,'MediaRenderer01');

       $this->set_cherga($terminal_rec['TITLE'],$level,$cached_filenam);

/**
* очередь сообщений 
*
* @access public
*/
function set_cherga($target,$levelMes,$cached_filename) { 

   // berem vse soobsheniya po urovnyu
   $l_level_mesage = SQLSelect("SELECT * FROM jobs WHERE TITLE LIKE'".'sayTo-timers-'.$target.'-level-'.$levelMes.'-number-'."%' ORDER BY `TITLE`");
   ///  last mesage for levelmes
   $last_mesage = max(array_column($l_level_mesage,'TITLE'));
   //DebMes ('max - '.$last_mesage);
   // opredelyaem posledniy nomer soobsheniya
   $pos = strripos($last_mesage, '-');
   $last_number = substr($last_mesage, $pos+1)+1;
   if ($last_number<1 ){
    $last_number='001';
    } else if ($last_number<10 ) {
    $last_number='00'.$last_number;
    } else {
    $last_number='0'.$last_number;
    }
    DebMes($last_number);

   // vibiraem vse soobsheniya dla terminala s sortirovkoy
   $all_messages = SQLSelect("SELECT * FROM jobs WHERE TITLE LIKE'".'sayTo-timers-'.$target.'-level-'.'%-number-'."%' ORDER BY `TITLE`");
   
   //$add_message = array ('TITLE'=>'sayTo-timers-'.$target.'-level-'.$levelMes.'-number-+1', 'COMMANDS'=>'play music', 'RUNTIME'=>'runtime','EXPIRE'=>'expaire');
   foreach ( $all_messages as $message)
   {
    $rec['ID']       = $message['ID'];
    $rec['TITLE']    = $message['TITLE'];
    $rec['COMMANDS'] = $message['COMMANDS'];
    $rec['RUNTIME']  = date('Y-m-d H:i:s', (strtotime($message['RUNTIME'])+$time_shift));
    $rec['EXPIRE']   = date('Y-m-d H:i:s', (strtotime($message['EXPIRE'])+$time_shift));
    SQLUpdate('jobs', $rec);
    
    if ($message['TITLE'] == $last_mesage) {
      $fin_time = strtotime($message['EXPIRE']);
      DebMes($fin_time);
      $time_shift = 30;
      addScheduledJob('sayTo-timers-'.$target.'-level-'.$levelMes.'-number-'.$last_number, "playMedia('".$cached_filename."','".$target."');", $fin_time, $time_shift);
      }
   }
}
