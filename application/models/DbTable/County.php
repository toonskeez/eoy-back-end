<?php

class Application_Model_DbTable_County extends Zend_Db_Table_Abstract
{

    protected $_name = 'county';

	/*
	public function getAll()
	{
		$select  = $this->_db->select()->from($this->_name, array('key' => 'id', 'value' => 'name'))->order('name ASC');
		$result = $this->getAdapter()->fetchAll($select);
		return $result;
	}
	*/
	
	public function getAll() // this function now necessary as id 0 = 'choose county', so need to place this at start of array
	{
		$select  = $this->_db->select()->from($this->_name, array('key' => 'id', 'value' => 'name'))->order('name ASC');
		$result = $this->getAdapter()->fetchAll($select);
		$result = array_merge(array("0" => "choose county"), $result);
		return $result;
	}

}

