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
            '0'=>array('DESCRIPTION'=>'Кнопка 0', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'0', 'DATA_KEY'=>1),
            '3'=>array('DESCRIPTION'=>'Кнопка 3', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'3', 'DATA_KEY'=>1),
            '4'=>array('DESCRIPTION'=>'Кнопка 4', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'4', 'DATA_KEY'=>1),
            '5'=>array('DESCRIPTION'=>'Кнопка 5', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'5', 'DATA_KEY'=>1),
            '6'=>array('DESCRIPTION'=>'Кнопка 6', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'6', 'DATA_KEY'=>1),
            '7'=>array('DESCRIPTION'=>'Кнопка 7', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'7', 'DATA_KEY'=>1),
            '8'=>array('DESCRIPTION'=>'Кнопка 8', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'8', 'DATA_KEY'=>1),
            '9'=>array('DESCRIPTION'=>'Кнопка 9', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'9', 'DATA_KEY'=>1),
            'F1'=>array('DESCRIPTION'=>'Кнопка F1', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'F1', 'DATA_KEY'=>1),
            'F2'=>array('DESCRIPTION'=>'Кнопка F2', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'F2', 'DATA_KEY'=>1),
            'F3'=>array('DESCRIPTION'=>'Кнопка F3', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'F3', 'DATA_KEY'=>1),
            'F4'=>array('DESCRIPTION'=>'Кнопка F4', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'F4', 'DATA_KEY'=>1),
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
            '3'=>array('DESCRIPTION'=>'3'),
            '4'=>array('DESCRIPTION'=>'4'),
            '5'=>array('DESCRIPTION'=>'5'),
            '6'=>array('DESCRIPTION'=>'6'),
            '7'=>array('DESCRIPTION'=>'7'),
            '8'=>array('DESCRIPTION'=>'8'),
            '9'=>array('DESCRIPTION'=>'9'),
            '0'=>array('DESCRIPTION'=>'0'),
            'F1'=>array('DESCRIPTION'=>'F1'),
            'F2'=>array('DESCRIPTION'=>'F2'),
            'F3'=>array('DESCRIPTION'=>'F3'),
            'F4'=>array('DESCRIPTION'=>'F4'),
        )
