<?php

class Application_Model_DbTable_MemberKeyword extends Zend_Db_Table_Abstract
{

    protected $_name = 'member_keyword';
	
	public function getMemberKeywords($m_id)
	{
		$m_id = (int)$m_id;
		$rows = $this->fetchAll('member_profile_id = ' . $m_id);
		if(!$rows) {
			return NULL;
		}
		return $rows->toArray();
	}
	
	public function addMemberKeyword($data)
	{
		$this->insert($data);
	}
	
	public function deleteMemberKeywords($m_id) // delete all records that have this member's id
	{
		$this->delete('member_profile_id = ' . (int)$m_id);
	}
	
	public function deleteMemberKeyword($m_id, $keyword_id) // delete keyword related to this member with this keyword text value
	{
		$this->delete('member_profile_id = ' . (int)$m_id . ' and keyword_id = ' . $keyword_id);
	}

}

