<?php

class Application_Model_DbTable_Company extends Zend_Db_Table_Abstract
{

    protected $_name = 'company';

	public function getAll()
	{
		$select  = $this->_db->select()->from($this->_name, array('key' => 'id', 'value' => 'current_company_name'))->order('current_company_name ASC');
		$result = $this->getAdapter()->fetchAll($select);
		return $result;
	}
	
	public function getCompany($id)
	{
		$id = (int)$id;
		$row = $this->fetchRow('id = ' . $id);
		if(!$row) {
			return NULL;
		}
		return $row->toArray();
	}
	
	public function addCompany($data)
	{
		$this->insert($data);
	}
	
	public function updateCompany($data, $id)
	{
		$this->update($data, 'id = ' . (int)$id);
	}
	
	public function deleteCompany($id)
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

