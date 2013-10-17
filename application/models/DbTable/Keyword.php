<?php

class Application_Model_DbTable_Keyword extends Zend_Db_Table_Abstract
{

    protected $_name = 'keyword';

	public function getAll()
	{
		$select  = $this->_db->select()->from($this->_name, array('key' => 'id', 'value' => 'value'))->order('value ASC');
		$result = $this->getAdapter()->fetchAll($select);
		return $result;
	}


}

