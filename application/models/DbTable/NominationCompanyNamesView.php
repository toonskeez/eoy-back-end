<?php

class Application_Model_DbTable_NominationCompanyNamesView extends Zend_Db_Table_Abstract
{

    protected $_name = 'nomination_company_names_view';
	// Need to set primary key as this is a view, not a table
	// if we don't set this, we'll get an error saying that table has no primary key
	
	// this view contains 3 fields: id (company id), curr_company_name, prev_company_name
	// some companies might have no previous company names, some might have one, some might have more than one
	// if a company has no previous company names, the prev_company_name field will return NULL
	
	protected $_primary  = 'id';
   	protected $_sequence = false;

	public function getAll()
	{
		$select  = $this->_db->select()->from($this->_name, array('key' => 'id', 'value' => 'curr_company_name'))->order('curr_company_name ASC');
		$result = $this->getAdapter()->fetchAll($select);
		return $result;
	}

}

