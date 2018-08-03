<?php

$this->device_types['BinaryLight'] = array(
        'TITLE'=>'UPNP выключатель',
        'PARENT_CLASS'=>'UPNPdevices',
        'CLASS'=>'SBinaryLight',
        'PROPERTIES'=>array(
            'turnOn'=>array('DESCRIPTION'=>'Включение', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'switch', 'DATA_KEY'=>1),
            'turnOff'=>array('DESCRIPTION'=>'Выключение', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'switch', 'DATA_KEY'=>1),
       ),
        'METHODS'=>array(
            'turnOn'=>array('DESCRIPTION'=>'turnOn'),
            'turnOff'=>array('DESCRIPTION'=>'turnOff'),
            'switch'=>array('DESCRIPTION'=>'Switch'),
        )
);
