<?php

class Application_Model_DbTable_AltContact extends Zend_Db_Table_Abstract
{

    protected $_name = 'alt_contact';

	public function getAltContact($id)
	{
		$id = (int)$id;
		$row = $this->fetchRow('id = ' . $id);
		if(!$row) {
			return NULL;
		}
		return $row->toArray();
	}
	
	public function addAltContact($data)
	{
		$this->insert($data);
	}
	
	public function updateAltContact($data, $id)
	{
		$this->update($data, 'id = ' . $id);
	}
	
	public function deleteAltContact($id)
	{
		$this->delete('id = ' . (int)$id);
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
	
}

