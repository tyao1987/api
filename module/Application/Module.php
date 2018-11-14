<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Application;

use Test\Util\Timer;
use Test\Data;

class Module
{
    
    public function onBootstrap(MvcEvent $e)
    {
        Timer::start(__METHOD__);
        
        // 获取 Data 实例
        $data = Data::getInstance();
        $applicationConfig = $e->getApplication()->getServiceManager()->get('config');
        
        $eventManager = $e->getApplication()->getEventManager();
        
        // 处理 404 和 500 错误
        $eventManager->attach('dispatch.error', function($event) use ($data) {
            
        	$error = $event->getError();
        	if (empty($error)) {
        		return;
        	}
        	switch ($error) {
        		case Application::ERROR_CONTROLLER_NOT_FOUND:
        		case Application::ERROR_CONTROLLER_INVALID:
        		case Application::ERROR_ROUTER_NO_MATCH:
        			$route = 'not_found';
        			$controller = 'Application\Controller\Index';
        			$action = 'notFoundAction';
        			break;
        		default:
        			$exception = $event->getParam('exception');
        			if(!empty($exception)){
        			    \Application\Exception::log($exception);
        				if(APPLICATION_ENV != "development") {
        					\Application\Exception::log($exception);
        				} else {
        					echo \Application\Exception::log($exception, true);
        					die;
        				}
        			}
        			$controller = 'Application\Controller\Index';
        			$action = 'errorAction';
        			break;
        	}
        	
        	$controllerLoader = $event->getApplication()->getServiceManager()->get('ControllerLoader');
        	$controller = $controllerLoader->get($controller);
        	$controller->setEvent($event);
        	
        	return $controller->{$action}();
        }, 100);
        $this->_initConfig();
        
        //设置时区
        date_default_timezone_set('Asia/Shanghai');
        
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        Timer::end(__METHOD__);
    }

    // 将 config.xml 转化为数组存进 \Test\Data 中
    protected function _initConfig()
    {
    	Timer::start(__METHOD__);
    	
    	$config = include (__DIR__ . "/config/config." . APPLICATION_ENV . ".php");
    	
    	Data::getInstance()->set('config', $config, true);
    
    	Timer::end(__METHOD__);
    }
    
    public function getConfig()
    {
        Timer::start(__METHOD__);
        
        // 加载 route 配置
        $router = require __DIR__ . '/config/router.php';
        $routerConfig = array("routes"=>$router);
        
        // 加载 module 配置
        $moduleConfig = require __DIR__ . '/config/module.config.php';
        
        $moduleConfig = array_merge(array('router' => $routerConfig), $moduleConfig);
        
        Timer::end(__METHOD__);
        
        return $moduleConfig;
        
    }

    public function getAutoloaderConfig()
    {
    	
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
}

