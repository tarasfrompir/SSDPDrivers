<?php

$this->device_types['MAG250'] = array(
        'TITLE'=>'UPNP Устройство воспроизведения',
        'PARENT_CLASS'=>'UPNPdevices',
        'CLASS'=>'SMAG250',
        'PROPERTIES'=>array(
            'mute_unmute'=>array('DESCRIPTION'=>'Отключение/включение звука', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'mute-unmute', 'DATA_KEY'=>1),
            'volume'=>array('DESCRIPTION'=>'Уровень звука', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'volume', 'DATA_KEY'=>1),
            'pause_unpause'=>array('DESCRIPTION'=>'Отключение/включение паузы', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'pause-unpause', 'DATA_KEY'=>1),
            'next'=>array('DESCRIPTION'=>'Следующая запись', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'next', 'DATA_KEY'=>1),
            'previous'=>array('DESCRIPTION'=>'Предыдущая запись', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'previous', 'DATA_KEY'=>1),
            'seeknext'=>array('DESCRIPTION'=>'Перемотка вперед на 30сек', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'seeknext', 'DATA_KEY'=>1),
            'seekprevious'=>array('DESCRIPTION'=>'Перемотка назад на 30сек', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'seekprevious', 'DATA_KEY'=>1),
            'stop'=>array('DESCRIPTION'=>'Стоп', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'stop', 'DATA_KEY'=>1),
            '1'=>array('DESCRIPTION'=>'Кнопка 1', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'1', 'DATA_KEY'=>1),
            '2'=>array('DESCRIPTION'=>'Кнопка 2', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'2', 'DATA_KEY'=>1),
       ),
        'METHODS'=>array(
            'mute-unmute'=>array('DESCRIPTION'=>'Отключение/включение звука'),
            'volume'=>array('DESCRIPTION'=>'Уровень звука'),
            'pause-unpause'=>array('DESCRIPTION'=>'Отключение/включение паузы'),
            'next'=>array('DESCRIPTION'=>'Следующий трек'),
            'previous'=>array('DESCRIPTION'=>'Предыдущий трек'),
            'seeknext'=>array('DESCRIPTION'=>'Перемотка вперед на 30сек'),
            'seekprevious'=>array('DESCRIPTION'=>'Перемотка назад на 30сек'),
            'stop'=>array('DESCRIPTION'=>'Стоп'),
            '1'=>array('DESCRIPTION'=>'1'),
            '2'=>array('DESCRIPTION'=>'2'),
        )
