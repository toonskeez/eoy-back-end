<?php

class Application_Model_DbTable_MemberCompany extends Zend_Db_Table_Abstract
{

    protected $_name = 'member_company';
	
	public function getMemberCompany($m_id, $c_id)
	{
		$m_id = (int)$m_id;
		$c_id = (int)$c_id;
		$row = $this->fetchRow('member_id = ' . $m_id . ' AND company_id = ' . $c_id);
		if(!$row) {
			return NULL;
		}
		return $row->toArray();
	}
	
	public function getMemberCompanies($m_id)
	{
		$m_id = (int)$m_id;
		$rows = $this->fetchAll('member_id = ' . $m_id);
		if(!$rows) {
			return NULL;
		}
		return $rows->toArray();
	}
	
	public function getMemberNominationCompany($m_id) {
		
		$m_id = (int)$m_id;
		$row = $this->fetchRow('member_id = ' . $m_id . ' AND company_type = ' . "'" . 'nomination' . "'");
		if(!$row) {
			return NULL;
		}
		return $row->toArray();
		
	}
	
	public function addMemberCompany($data)
	{
		$this->insert($data);
	}
	
	public function updateMemberCompany($m_id, $c_id)
	{
		$this->update($data, 'member_id = ' . $m_id . ' AND company_id = ' . $c_id);
	}

}

