<?php

class Application_Model_DbTable_OfficeAddress extends Zend_Db_Table_Abstract
{

    protected $_name = 'office_address';
	
	public function getOfficeAddress($id)
	{
		$id = (int)$id;
		$row = $this->fetchRow('id = ' . $id);
		if(!$row) {
			return NULL;
		}
		return $row->toArray();
	}
	
	public function addOfficeAddress($data)
	{
		$this->insert($data);
	}
	
	public function updateOfficeAddress($data, $id)
	{
		$this->update($data, 'id = ' . (int)$id);
	}
	
	public function getLastEntered()
	{
		$id = $this->getAdapter()->lastInsertId();
		
		$row = $this->fetchRow('id = ' . $id);
		
		if(!$row) {
			return NULL;
		}
		return $row->toArray();
		 		 
	}
	
	public function deleteOfficeAddress($id)
	{
		$this->delete('id = ' . (int)$id);
	}
	
}

