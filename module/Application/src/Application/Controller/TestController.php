<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;


class TestController extends AbstractController
{
    public function indexAction()
    {
        echo "test";exit;
        exit;
    }
    
    public function bbbAction()
    {
        echo "bbb";
        exit;
    }
}

?>
