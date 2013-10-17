<?php

class Application_Model_DbTable_MemberOtherCompanies extends Zend_Db_Table_Abstract
{

    protected $_name = 'member_other_companies';

	public function getMemberOtherCompanies($m_id)
	{
		$m_id = (int)$m_id;
		$rows = $this->fetchAll('member_profile_id = ' . $m_id);
		if(!$rows) {
			return NULL;
		}
		return $rows->toArray();
	}
	
	public function addMemberOtherCompany($data)
	{
		$this->insert($data);
	}
	
	public function deleteMemberOtherCompanies($m_id) // delete all other companies related to this member
	{
		$this->delete('member_profile_id = ' . (int)$m_id);
	}
	
	public function deleteMemberOtherCompany($m_id, $other_company) // delete other company related to this member with the other company text value
	{
		$this->delete('member_profile_id = ' . (int)$m_id . ' and value = ' . $other_company);
	}

}

