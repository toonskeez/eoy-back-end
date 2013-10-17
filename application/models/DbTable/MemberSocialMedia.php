<?php

class Application_Model_DbTable_MemberSocialMedia extends Zend_Db_Table_Abstract
{

    protected $_name = 'member_social_media';

	public function getMemberSocialMedia($m_id)
	{
		$m_id = (int)$m_id;
		$row = $this->fetchRow('member_profile_id = ' . $m_id);
		if(!$row) {
			return NULL;
		}
		return $row->toArray();
	}
	
	public function addMemberSocialMedia($data)
	{
		$this->insert($data);
	}
	
	public function updateMemberSocialMedia($data, $m_id)
	{
		$this->update($data, 'member_profile_id = ' . $m_id);
	}

}

