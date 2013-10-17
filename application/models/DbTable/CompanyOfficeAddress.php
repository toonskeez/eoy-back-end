<?php

class Application_Model_DbTable_CompanyOfficeAddress extends Zend_Db_Table_Abstract
{

    protected $_name = 'company_office_address';
	
	public function getCompanyOfficeAddress($c_id, $office_address_id, $address_type)
	{
		$c_id = (int)$c_id;
		$office_address_id = (int)$office_address_id;
		$row = $this->fetchRow('company_id = ' . $c_id . ' AND office_address_id = '
								. $office_address_id . ' AND address_type = ' . "'" . $address_type . "'");
		if(!$row) {
			return NULL;
		}
		return $row->toArray();
	}
	
	public function getOfficeAddressId($c_id, $address_type)
	{
		$c_id = (int)$c_id;
		$row = $this->fetchRow('company_id = ' . $c_id . ' AND address_type = ' . "'" . $address_type . "'");
		if(!$row) {
			return NULL;
		}
		$row = $row->toArray();
		return $row['office_address_id'];
	}
	
	public function addCompanyOfficeAddress($data)
	{
		$this->insert($data);
	}
	
	public function updateCompanyOfficeAddress($c_id, $office_address_id, $address_type)
	{
		$this->update($data, 'company_id = ' . $c_id . ' AND office_address_id = '
								. $office_address_id . ' AND address_type = ' . "'" . $address_type . "'");
	}

}

