<?php

class Application_Model_DbTable_MemberAltContact extends Zend_Db_Table_Abstract
{

    protected $_name = 'member_alt_contact';
	
	public function getMemberAltContact($m_id)
	{
		$m_id = (int)$m_id;
		$row = $this->fetchRow('member_profile_id = ' . $m_id);
		if(!$row) {
			return NULL;
		}
		return $row->toArray();
	}
	
	/*
	public function getMemberAltContact($m_id, $contact_id)
	{
		$m_id = (int)$m_id;
		$contact_id = (int)$contact_id;
		$row = $this->fetchRow('member_profile_id = ' . $m_id . ' AND alt_contact_id = ' . $contact_id);
		if(!$row) {
			return NULL;
		}
		return $row->toArray();
	}
	*/
	
	public function addMemberAltContact($data)
	{
		$this->insert($data);
	}
	
	public function updateMemberAltContact($data, $m_id)
	{
		$this->update($data, 'member_profile_id = ' . $m_id);
	}

}

