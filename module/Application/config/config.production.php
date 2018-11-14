<?php

return array(
    'writableDir' => array(
        'base'            => '',
		'log'             => '/var/log/www/api/',
    ), 
    'log' => array(
        'enabled'    => true,
        'file'       => 'error',
        'email'      => true,
    	'emailTimeZone' => 'Asia/Shanghai',
        'slowConnection' => 6,
    ),
    
);

