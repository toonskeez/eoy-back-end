<?php

class Application_Model_DbTable_CompanyOtherWebsites extends Zend_Db_Table_Abstract
{

    protected $_name = 'company_other_websites';
	
	public function getCompanyOtherWebsites($c_id)
	{
		$c_id = (int)$c_id;
		$rows = $this->fetchAll('company_id = ' . $c_id);
		if(!$rows) {
			return NULL;
		}
		return $rows->toArray();
	}
	
	public function addCompanyOtherWebsite($data)
	{
		$this->insert($data);
	}
	
	public function deleteCompanyOtherWebsites($c_id) // delete all other websites related to this company
	{
		$this->delete('company_id = ' . (int)$c_id);
	}

}

