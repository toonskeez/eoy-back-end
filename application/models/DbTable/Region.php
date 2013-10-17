<?php

class Application_Model_DbTable_Region extends Zend_Db_Table_Abstract
{

    protected $_name = 'region';

	public function getAll()
	{
		$select  = $this->_db->select()->from($this->_name, array('key' => 'id', 'value' => 'name'))->order('id ASC');
		$result = $this->getAdapter()->fetchAll($select);
		return $result;
	}


}

