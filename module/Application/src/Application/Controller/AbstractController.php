<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;



use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

use Test\Data;
use Test\Util\Timer;



abstract class AbstractController extends AbstractActionController {
    
    /**
     * @var 请求参数，包含  get 和 route 参数
     */
    protected $params = array();
    
    /**
     * (non-PHPdoc)
     * @see Zend\Mvc\Controller\AbstractController::attachDefaultListeners()
     */
    protected function attachDefaultListeners() {
    	
        Timer::start(__METHOD__);
        
		parent::attachDefaultListeners();
		$events = $this->getEventManager();
		$this->events->attach(MvcEvent::EVENT_DISPATCH, array($this, 'preDispatch'), 1000);
		$this->events->attach(MvcEvent::EVENT_DISPATCH, array($this, 'postDispatch'), -1000);
		
		Timer::end(__METHOD__);
	}
	
	/**
	 * Dispatch 前，将需要的数据获取到，附加到 protected 属性中
	 * 
	 * @param MvcEvent $e
	 */
	public function preDispatch(MvcEvent $e) {
		
	    Timer::start(__METHOD__);
	    
	    // 注册 get + route 参数
	    $this->params = array_merge($this->params()->fromQuery(), $this->params()->fromRoute());
	    
	    Timer::end(__METHOD__);
	}
	
	public function errorAction() {
	    echo $this->result(array('code'=>500));exit;
	}
	
	
	public function notFoundAction() {
	    echo $this->result(array('code'=>404));exit;
	}
	
	
	/**
	 * Dispatch 后，将需要的数据附加到 viewModel 中，比如 seo-template， google Analytics
	 *
	 * @param MvcEvent $e
	 */
	public function postDispatch(MvcEvent $e) {
	    
	}
	
	/**
	 *
	 * @param $result array();
	 * $result['code']
	 * $result['data']
	 * $result['msg']
	 */
	
	public function result($result){
	    $result['code'] = $result['code'] ? $result['code'] : 0;
	    if($result['code'] == 0){
	        if(is_array($result['data']) && !$result['data']){
	           $result['data'] = array();
	        }
	        if(!is_array($result['data'])){
	            $result['data'] = $result['data'] ? $result['data'] : new \stdClass();
	        }
	    }else{
	        $result['data'] = new \stdClass();
	    }
	    
	    if(!isset($result['msg'])){
	        $resultCode = require_once ROOT_PATH . '/module/Application/config/result_code.php';
	        $result['msg'] = $resultCode[$result['code']] ? $resultCode[$result['code']] : '';
	    }
	    
	    return json_encode($result);
	}
	
	//不适用多维数组
	public function filterData($filter,$data){
	    if($data){
	        if(is_object($data)){
	            foreach ($data as $key => $value){
	                if(!in_array($key, $filter)){
	                    unset($data->{$key});
	                }
	            }
	        }else if(is_array($data)){
	            foreach ($data as $key => $value){
	                $rowKeys = array_keys($value);
	                foreach ($rowKeys as $k){
	                    if(!in_array($k, $filter)){
	                        unset($value[$k]);
	                    }
	                }
	                $data[$key] = $value;
	            }
	        }
	    }
	    return $data;
	}
	
}
