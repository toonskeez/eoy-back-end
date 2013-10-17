<?php

class Application_Model_DbTable_MemberOtherInfo extends Zend_Db_Table_Abstract
{

    protected $_name = 'member_other_info';

	public function getMemberOtherInfo($m_id)
	{
		$m_id = (int)$m_id;
		$row = $this->fetchRow('member_profile_id = ' . $m_id);
		if(!$row) {
			return NULL;
		}
		return $row->toArray();
	}
	
	public function addMemberOtherInfo($data)
	{
		$this->insert($data);
	}
	
	public function updateMemberOtherInfo($data, $m_id)
	{
		$this->update($data, 'member_profile_id = ' . (int)$m_id);
	}
	
	public function deleteMemberOtherInfo($m_id)
	{
		$this->delete('member_profile_id = ' . (int)$m_id);
	}

}

