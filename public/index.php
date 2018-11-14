<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
define('ROOT_PATH', dirname(dirname(__FILE__)));

chdir(ROOT_PATH);
// 定义应用运行环境，可以在 .htaccess 中设置 SetEnv APPLICATION_ENV development
defined('APPLICATION_ENV')
|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV')?getenv('APPLICATION_ENV'):'production'));

defined('ACTIVE_MODULE')
|| define('ACTIVE_MODULE', (getenv('ACTIVE_MODULE')?getenv('ACTIVE_MODULE'):'application'));

// 不是生产环境则允许显示错误，以方便调试
if (APPLICATION_ENV == 'development') {
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
	ini_set('display_startup_errors', 1);
	ini_set('display_errors', 1);
} else {
	// 是产品环境则不允许显示错误
	ini_set('display_startup_errors', 0);
	ini_set('display_errors', 0);
}

// Setup autoloading
require 'init_autoloader.php';


$application = Zend\Mvc\Application::init(require 'config/module/' . ACTIVE_MODULE . '.php');
$application->run();

 	


