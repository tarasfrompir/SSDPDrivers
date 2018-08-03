<?php

$this->device_types['dial'] = array(
        'TITLE'=>'UPNP DIAL устройство',
        'PARENT_CLASS'=>'UPNPdevices',
        'CLASS'=>'Sdial',
        'PROPERTIES'=>array(
            'PlayURL'=>array('DESCRIPTION'=>' Play Url','ONCHANGE'=>'updatePreview','_CONFIG_TYPE'=>'text'),
            'Applications'=>array('DESCRIPTION'=>' Приложения','_CONFIG_TYPE'=>'text'),
        ),
);
