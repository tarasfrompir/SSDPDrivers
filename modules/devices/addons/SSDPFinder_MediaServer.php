<?php
 $this->device_types['MediaServer'] = array(
        'TITLE'=>'UPNP Медиасервер',
        'PARENT_CLASS'=>'UPNPdevices',
        'CLASS'=>'SMediaServer',
        'PROPERTIES'=>array(
            'getFileList'=>array('DESCRIPTION'=>'При изменении Получает список файлов на устройстве', 'KEEP_HISTORY'=>1, 'ONCHANGE'=>'getFileList', 'DATA_KEY'=>1),
       ),
        'METHODS'=>array(
            'getFileList'=>array('DESCRIPTION'=>'Получает список файлов на устройстве'),

        )
);
