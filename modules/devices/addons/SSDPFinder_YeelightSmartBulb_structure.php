<?php

$this->device_types['YeelightSmartBulb'] = array(
        'TITLE'=>'Yeelight лампа',
        'PARENT_CLASS'=>'UPNPdevices',
        'CLASS'=>'SYeelightSmartBulb',
        'PROPERTIES'=>array(
            'turnOn'=>array('DESCRIPTION'=>'Включение', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'switch', 'DATA_KEY'=>1),
            'turnOff'=>array('DESCRIPTION'=>'Выключение', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'switch', 'DATA_KEY'=>1),
			'changecolor'=>array('DESCRIPTION'=>'Изменить цвет', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'changecolor', 'DATA_KEY'=>1),
			'changetemp'=>array('DESCRIPTION'=>'Изменить температуру', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'changetemp', 'DATA_KEY'=>1),
       ),
        'METHODS'=>array(
            'turnOn'=>array('DESCRIPTION'=>'Включение'),
            'turnOff'=>array('DESCRIPTION'=>'Выключение'),
            'switch'=>array('DESCRIPTION'=>'Изменить состояние'),
			'changecolor'=>array('DESCRIPTION'=>'Изменить цвет'),
			'changetemp'=>array('DESCRIPTION'=>'Изменить температуру'),
        )
);