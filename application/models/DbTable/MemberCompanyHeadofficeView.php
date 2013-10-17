<?php

class Application_Model_DbTable_MemberCompanyHeadofficeView extends Zend_Db_Table_Abstract
{
	// This is a view, not a table. It contains all fields that we might want to display on the home page for members:
	// including profile details, bio, company details, company head office address, etc.
    protected $_name = 'member_company_headoffice_view';
	// Need to set primary key as this is a view, not a table
	// if we don't set this, we'll get an error saying that table has no primary key
	protected $_primary  = 'id';
   	protected $_sequence = false;
	
	
	public function getMembersByIds($m_ids)
	{
		foreach($m_ids as $m_id) {
			$m_id = (int)$m_id;
		}
		
		$ids = implode(',', $m_ids);
		
		$rows = $this->fetchAll('member_id in (' . $ids . ')', 'first_name ASC');
		if(!$rows) {
			return NULL;
		}
		return $rows->toArray();
		
	}
	
	
}

