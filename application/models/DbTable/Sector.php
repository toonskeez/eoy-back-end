<?php

class Application_Model_DbTable_Sector extends Zend_Db_Table_Abstract
{

    protected $_name = 'sector';

	public function getAll()
	{
		$select  = $this->_db->select()->from($this->_name, array('key' => 'id', 'value' => 'name'))->order('name ASC');
		$result = $this->getAdapter()->fetchAll($select);
		return $result;
	}


}

