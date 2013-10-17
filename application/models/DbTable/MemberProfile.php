<?php

class Application_Model_DbTable_MemberProfile extends Zend_Db_Table_Abstract
{

    protected $_name = 'member_profile';


	public function getMemberProfile($id)
	{
		$id = (int)$id;
		$row = $this->fetchRow('id = ' . $id);
		if(!$row) {
			return NULL;
		}
		return $row->toArray();
	}
	
	
	public function getMembersByIds($m_ids)
	{
		foreach($m_ids as $m_id) {
			$m_id = (int)$m_id;
		}
		
		$ids = implode(',', $m_ids);
		
		$rows = $this->fetchAll('id in (' . $ids . ')', 'first_name ASC');
		if(!$rows) {
			return NULL;
		}
		return $rows->toArray();
		
	}
	
	
	public function addMemberProfile($data)
	{
		$this->insert($data);
	}
	
	
	public function updateMemberProfile($data, $id)
	{
		$this->update($data, 'id = ' . $id);
	}
	
	
	public function deleteMemberProfile($id)
	{
		$this->delete('id = ' . (int)$id);
	}
	
	
	public function getLastEntered()
	{
		$id = $this->getAdapter()->lastInsertId();
		
		$row = $this->fetchRow('id = ' . $id);
		
		if(!$row) {
			return NULL;
		}
		return $row->toArray(); 		 
	}
	
	
	public function getMemberIdsByParamsExclusive($params)
	{
		// for each param (select list) set in the form,
		// get member ids. for multiple selects, get member ids
		// for each one in a loop and only keep ids that are same in each returned set of ids
		// then compare all sets of member ids and only keep ones that appear in every returned set of ids
		// i.e.:  do a final select where member id in (any remaining ids)
		$memberIds = array();
		$resultIds = array();
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = new Zend_Db_Select($db);

		$select->distinct()->from(array('t1' => 'member_profile'));
			
		if (isset($params['name']) && $params['name'] != NULL) {
			$resultIds[] = $this->getMemberIdsByName($params['name']);
		}	
			
			
		if (isset($params['counties']) && $params['counties'] != NULL) {
				
			$all_ids = array(); // if 1 county selected, this array will contain 1 array, if 2 counties, 2 arrays...
			$keep_ids = array(); // will store results of all intersected arrays
			
			$countyIds = $params['counties'];
			
			$i = 0;
			foreach($countyIds as $countyId) {
				$c_id = array();
				$c_id[] = (int)$countyId; // need to wrap each number as an array so we can pass it to getMemberIdsByCounties function
				$all_ids[] = $this->getMemberIdsByCounties($c_id);
				
				if($all_ids[$i] == NULL) { // getMemberIdsByCounties returns NULL if no member ids, so need to set value in array
					$all_ids[$i] = array("-1"); // no member id will ever be -1
				}
				$i++;
			}
			
			if(sizeof($all_ids) == 1) { // need to make copy of itself, otherwise wiil get warning from array_intersect function
				// as it expects at least 2 arrays to compare
				$all_ids[] = $all_ids[0];
			}
			
			$keep_ids = call_user_func_array('array_intersect', $all_ids);
			$resultIds[] = $keep_ids;
			
		}	
		

		if (isset($params['regions']) && $params['regions'] != NULL) {
			
			$all_ids = array(); // if 1 region selected, this array will contain 1 array, if 2 regions, 2 arrays...
			$keep_ids = array(); // will store results of all intersected arrays
			
			$regionIds = $params['regions'];
			
			$i = 0;
			foreach($regionIds as $regionId) {
				$r_id = array();
				$r_id[] = (int)$regionId; // need to wrap each number as an array so we can pass it to getMemberIdsByRegions function
				$all_ids[] = $this->getMemberIdsByRegions($r_id);
				
				if($all_ids[$i] == NULL) { // getMemberIdsByRegions returns NULL if no member ids, so need to set value in array
					$all_ids[$i] = array("-1"); // no member id will ever be -1
				}
				$i++;
			}
			
			if(sizeof($all_ids) == 1) { // need to make copy of itself, otherwise wiil get warning from array_intersect function
				// as it expects at least 2 arrays to compare
				$all_ids[] = $all_ids[0];
			}
			
			$keep_ids = call_user_func_array('array_intersect', $all_ids);
			$resultIds[] = $keep_ids;
			
		}
		

		if (isset($params['sectors']) && $params['sectors'] != NULL) {
			
			$all_ids = array(); // if 1 region selected, this array will contain 1 array, if 2 regions, 2 arrays...
			$keep_ids = array(); // will store results of all intersected arrays
			
			$sectorIds = $params['sectors'];
			
			$i = 0;
			foreach($sectorIds as $sectorId) {
				$s_id = array();
				$s_id[] = (int)$sectorId; // need to wrap each number as an array so we can pass it to getMemberIdsByRegions function
				$all_ids[] = $this->getMemberIdsBySectors($s_id);
				
				if($all_ids[$i] == NULL) { // getMemberIdsByRegions returns NULL if no member ids, so need to set value in array
					$all_ids[$i] = array("-1"); // no member id will ever be -1
				}
				$i++;
			}
			
			if(sizeof($all_ids) == 1) { // need to make copy of itself, otherwise wiil get warning from array_intersect function
				// as it expects at least 2 arrays to compare
				$all_ids[] = $all_ids[0];
			}
			
			$keep_ids = call_user_func_array('array_intersect', $all_ids);
			$resultIds[] = $keep_ids;
			
		}
		

		if (isset($params['keywords']) && $params['keywords'] != NULL) {
			
			$all_ids = array(); // if 1 keyword selected, this array will contain 1 array, if 2 keywords, 2 arrays...
			$keep_ids = array(); // will store results of all intersected arrays
			
			$keywordIds = $params['keywords'];
			
			$i = 0;
			foreach($keywordIds as $keywordId) {
				$k_id = array();
				$k_id[] = (int)$keywordId; // need to wrap each number as an array so we can pass it to getMemberIdsByKeywords function
				$all_ids[] = $this->getMemberIdsByKeywords($k_id);
				
				if($all_ids[$i] == NULL) { // getMemberIdsByKeywords returns NULL if no member ids, so need to set value in array
					$all_ids[$i] = array("-1"); // no member id will ever be -1
				}
				$i++;
			}
			
			if(sizeof($all_ids) == 1) { // need to make copy of itself, otherwise wiil get warning from array_intersect function
				// as it expects at least 2 arrays to compare
				$all_ids[] = $all_ids[0];
			}
			
			$keep_ids = call_user_func_array('array_intersect', $all_ids);
			$resultIds[] = $keep_ids;
			
		}
		
		
		if (isset($params['num_employees']) && $params['num_employees'] != NULL) {
			
			$all_ids = array(); // if 1 numEmployee option selected, this array will contain 1 array, if 2 opts selected, 2 arrays...
			$keep_ids = array(); // will store results of all intersected arrays
			
			$numEmpIds = $params['num_employees'];
			
			$i = 0;
			foreach($numEmpIds as $numEmpId) {
				$n_id = array();
				$n_id[] = (int)$numEmpId; // need to wrap each number as an array so we can pass it to getMemberIdsByNumEmployees function
				$all_ids[] = $this->getMemberIdsByNumEmployees($n_id);
				
				if($all_ids[$i] == NULL) { // getMemberIdsByNumEmployees returns NULL if no member ids, so need to set value in array
					$all_ids[$i] = array("-1"); // no member id will ever be -1
				}
				$i++;
			}
			
			if(sizeof($all_ids) == 1) { // need to make copy of itself, otherwise wiil get warning from array_intersect function
				// as it expects at least 2 arrays to compare
				$all_ids[] = $all_ids[0];
			}
			
			$keep_ids = call_user_func_array('array_intersect', $all_ids);
			$resultIds[] = $keep_ids;
			
		}
		
		if(sizeof($resultIds) == 1) { // need to make copy of itself, otherwise wiil get warning from array_intersect function
			// as it expects at least 2 arrays to compare
			$resultIds[] = $resultIds[0];
		}
		
		
		$memberIds = call_user_func_array('array_intersect', $resultIds); // makes a new array with common values in all arrays
		
		if($memberIds == NULL || sizeof($memberIds) == 0) {
			return NULL;
		}
		
		$memberIds = implode(',', $memberIds);
		
		$select->where('t1.id in (' . $memberIds . ')');
		$result = $select->query();
		$resultSet = $result->fetchAll();
		
		if(!$resultSet) {
			return NULL;
		}
		
		$m_ids = array();
		foreach($resultSet as $member) {
			$m_ids[] = $member['id'];
		}
		return $m_ids;
		
	}
	
	
	public function getMemberIdsByParamsInclusive($params)
	{
		// this function gets members by calling internal functions based
		// on selected user criteria
		$memberIds = array();
		$resultIds = array('membersByName' => array(), 'membersByCounties' => array(),
						'membersByRegions' => array(), 'membersBySectors' => array(),
						'membersByKeywords' => array(), 'membersByNumEmployees' => array());
						
		
		if (isset($params['name'])) {
			$resultIds['membersByName'] = $this->getMemberIdsByName($params['name']);
		}	
			

		if (isset($params['counties'])) {
			$resultIds['membersByCounties'] = $this->getMemberIdsByCounties($params['counties']);
		}	
		

		if (isset($params['regions'])) {
			$resultIds['membersByRegions'] = $this->getMemberIdsByRegions($params['regions']);
		}
		

		if (isset($params['sectors'])) {
			$resultIds['membersBySectors'] = $this->getMemberIdsBySectors($params['sectors']);
		}
		

		if (isset($params['keywords'])) {
			$resultIds['membersByKeywords'] = $this->getMemberIdsByKeywords($params['keywords']);
		}
		

		if (isset($params['num_employees'])) {
			$resultIds['membersByNumEmployees'] = $this->getMemberIdsByNumEmployees($params['num_employees']);
		}
		
		foreach($resultIds as $ids) {
			if(isset($ids) && $ids != NULL) {
				$memberIds = array_merge($memberIds, $ids);
			}
		}		
		
		return $memberIds;
	}
	
	
	public function getMemberIdsByName($name) {
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = new Zend_Db_Select($db);
		
		$select->from(array('t1' => 'member_profile'))
			->where('first_name = ?', $name)
			->order('t1.first_name ASC');

		$result = $select->query();
		$resultSet = $result->fetchAll();
		
		if(!$resultSet) {
			return NULL;
		}
		
		$m_ids = array();
		foreach($resultSet as $member) {
			$m_ids[] = $member['id'];
		}
		return $m_ids;

	}
	
	
	public function getMemberIdsByCounties($counties) {
		
		$counties = implode(',', $counties);
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = new Zend_Db_Select($db);
		
		$select->distinct()->from(array('t1' => 'member_profile'))
			->join(array('t2' => 'member_company'),'t1.id = t2.member_id')
			->join(array('t3' => 'company'),'t2.company_id = t3.id')
			->join(array('t4' => 'company_office_address'),'t3.id = t4.company_id')
			->join(array('t5' => 'office_address'),'t4.office_address_id = t5.id and t4.company_id = t3.id')
			->joinLeft(array('t6' => 'county'),'t5.county_id = t6.id')
			->where('t5.county_id in (' . $counties . ')')
			->order('t1.first_name ASC');
		
		$result = $select->query();
		$resultSet = $result->fetchAll();
		
		if(!$resultSet) {
			return NULL;
		}
		
		$m_ids = array();
		foreach($resultSet as $member) {
			$m_ids[] = $member['member_id'];
		}
		return $m_ids;
		
	}
	
	
	public function getMemberIdsByRegions($regions) {
		
		$regions = implode(',', $regions);
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = new Zend_Db_Select($db);
		
		$select->from(array('t1' => 'member_profile'))
			->join(array('t2' => 'member_company'),'t1.id = t2.member_id')
			->join(array('t3' => 'company'),'t2.company_id = t3.id')
			->join(array('t4' => 'company_office_address'),'t3.id = t4.company_id')
			->join(array('t5' => 'office_address'),'t4.office_address_id = t5.id and t4.company_id = t3.id')
			->join(array('t6' => 'country'),'t5.country_id = t6.id')
			->join(array('t7' => 'region_country'),'t6.id = t7.country_id')
			->join(array('t8' => 'region'),'t7.region_id = t8.id')
			->where('t8.id in (' . $regions . ')')
			->order('t1.first_name ASC');
		
		$result = $select->query();
		$resultSet = $result->fetchAll();
		
		if(!$resultSet) {
			return NULL;
		}
		
		$m_ids = array();
		foreach($resultSet as $member) {
			$m_ids[] = $member['member_id'];
		}
		return $m_ids;
		
	}


	public function getMemberIdsBySectors($sectors) {
		
		$sectors = implode(',', $sectors);
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = new Zend_Db_Select($db);
		
		$select->from(array('t1' => 'member_profile'))
			->join(array('t2' => 'member_company'),'t1.id = t2.member_id')
			->join(array('t3' => 'company'),'t2.company_id = t3.id')
			->join(array('t4' => 'sector'),'t3.sector_id = t4.id')
			->where('t4.id in (' . $sectors . ')')
			->order('t1.first_name ASC');		
			
		$result = $select->query();
		$resultSet = $result->fetchAll();
		
		if(!$resultSet) {
			return NULL;
		}
		
		$m_ids = array();
		foreach($resultSet as $member) {
			$m_ids[] = $member['member_id'];
		}
		return $m_ids;
	}
	
	
	public function getMemberIdsByKeywords($keywords) {
		
		$keywords = implode(',', $keywords);
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = new Zend_Db_Select($db);
		
		$select->from(array('t1' => 'member_profile'))
			->join(array('t2' => 'member_keyword'),'t1.id = t2.member_profile_id')
			->join(array('t3' => 'keyword'),'t2.keyword_id = t3.id')
			->where('t3.id in (' . $keywords . ')');
			
		$result = $select->query();
		$resultSet = $result->fetchAll();
		
		if(!$resultSet) {
			return NULL;
		}
		
		$m_ids = array();
		foreach($resultSet as $member) {
			$m_ids[] = $member['member_profile_id'];
		}
		return $m_ids;
		
	}
	
	
	public function getMemberIdsByNumEmployees($numEmployees) {
		
		$numEmployees = implode(',', $numEmployees);
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = new Zend_Db_Select($db);
		
		$select->from(array('t1' => 'member_profile'))
			->join(array('t2' => 'member_company'),'t1.id = t2.member_id')
			->join(array('t3' => 'company'),'t2.company_id = t3.id')
			->join(array('t4' => 'number_of_employees'),'t3.number_of_employees_id = t4.id')
			->where('t4.id in (' . $numEmployees . ')')
			->order('t1.first_name ASC');		
		
		$result = $select->query();
		$resultSet = $result->fetchAll();
		
		if(!$resultSet) {
			return NULL;
		}
		
		$m_ids = array();
		foreach($resultSet as $member) {
			$m_ids[] = $member['member_id'];
		}
		return $m_ids;
		
	}
	
	
}

