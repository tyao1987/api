<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;


use Application\Model\News;

class IndexController extends AbstractController
{
    public function indexAction()
    {
        throw new \Exception("aaa");
        $filter = array('id','create_time');
        $news = new News();
        $row = $news->getNewsById(51);
        if($row){
            $row = $this->filterData($filter, $row);
        }
        $rows = $news->getList();
        if($rows){
            $rows = $this->filterData($filter, $rows);
        }
        $result['data'] = $rows;
        $result['data'] = $row;
        echo $this->result($result);exit;
       
    }
    
}

?>
