<?php

class Application_Model_DbTable_MemberBio extends Zend_Db_Table_Abstract
{

    protected $_name = 'member_bio';

	public function getMemberBio($m_id)
	{
		$m_id = (int)$m_id;
		$row = $this->fetchRow('member_profile_id = ' . $m_id);
		if(!$row) {
			return NULL;
		}
		return $row->toArray();
	}
	
	public function addMemberBio($data)
	{
		$this->insert($data);
	}
	
	public function updateMemberBio($data, $m_id)
	{
		$this->update($data, 'member_profile_id = ' . (int)$m_id);
	}
	
	public function deleteMemberBio($m_id)
	{
		$this->delete('member_profile_id = ' . (int)$m_id);
	}

}

