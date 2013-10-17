<?php

class Application_Model_DbTable_CompanyPrevNames extends Zend_Db_Table_Abstract
{

    protected $_name = 'company_previous_names';

	public function getCompanyPrevNames($c_id)
	{
		$c_id = (int)$c_id;
		
		$rows = $this->fetchAll('company_id = ' . $c_id);
		if(!$rows) {
			return NULL;
		}
		return $rows->toArray();
	}
	
	public function nameExists($c_id, $prev_name) {
		
		$c_id = (int)$c_id;
		// mysql_real_escape_string escapes illegal chars like single quotes
		$where = 'company_id = ' . $c_id . ' and prev_name = ' . "'" . mysql_real_escape_string($prev_name) . "'";
		
		$row = $this->fetchRow($where);
		if(!$row) {
			return FALSE;
		} else {
			return TRUE;
		}
		
	}
	
	
	public function addCompanyPrevName($data)
	{
		$this->insert($data);
	}

}

