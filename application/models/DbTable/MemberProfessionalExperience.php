<?php

class Application_Model_DbTable_MemberProfessionalExperience extends Zend_Db_Table_Abstract
{

    protected $_name = 'member_professional_experience';

	public function getMemberProfessionalExperience($m_id)
	{
		$m_id = (int)$m_id;
		$row = $this->fetchRow('member_profile_id = ' . $m_id);
		if(!$row) {
			return NULL;
		}
		return $row->toArray();
	}
	
	public function addMemberProfessionalExperience($data)
	{
		$this->insert($data);
	}
	
	public function updateMemberProfessionalExperience($data, $m_id)
	{
		$this->update($data, 'member_profile_id = ' . (int)$m_id);
	}
	
	public function deleteMemberProfessionalExperience($m_id)
	{
		$this->delete('member_profile_id = ' . (int)$m_id);
	}

}

