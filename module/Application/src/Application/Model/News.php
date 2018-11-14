<?php
namespace Application\Model;

use Application\Model\DbTable;
use Zend\Db\Sql\Select;

class News extends DbTable
{
	protected $_name = 'news';
	protected $_primary = 'id';


	function __construct(){
		$this->setTableGateway("cmsdb", $this->_name);
		$this->_select = $this->tableGateway->getSql()->select();
	}

	public function getNewsById($id)
	{
	    $result = $this->fetchRow(array('id'=> $id));
	    return $result;
	}
	
	public function getList(){
	    $data = $this->tableGateway->getAdapter();
	    $this->_select->where("status = 2323");
	    $this->_select->order("start_date DESC");
	    return $this->fetchAll($this->_select->getSqlString($data->getPlatform()));
	}
	
}