<?php
$configProduction = require ROOT_PATH . '/module/Application/config/config.production.php';

$config = array(
);
return array_merge($configProduction,$config);

