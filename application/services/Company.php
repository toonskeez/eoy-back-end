<?php

class Application_Service_Company {
	
	public function save($form)
	{
		if($form == NULL)
		{
			Zend_Session::start();
			$addMember = new Zend_Session_Namespace('addMember');
				
			$current_company_name = $addMember->current_company_name;
			$company_website = $addMember->company_website;
			$number_of_employees_id = $addMember->num_employees_sel;
			$sector_id = $addMember->sector_sel;
		}
		else
		{
			$current_company_name = $form->getValue('current_company_name');
			$company_website = $form->getValue('company_website');
			$number_of_employees_id = $form->getValue('num_employees_sel');
			$sector_id = $form->getValue('sector_sel');
		}
		
		$data = array(
			'current_company_name' => $current_company_name,
			'company_website' => $company_website,
			'number_of_employees_id' => $number_of_employees_id,
			'sector_id' => $sector_id,
		);
		
		$company = new Application_Model_DbTable_Company();
		$company->addCompany($data);
				
	}
	
	public function saveOffice($c_id, $form, $office_type) {
			
		if($form == NULL)
		{
			Zend_Session::start();
			$addMember = new Zend_Session_Namespace('addMember');
		
			$address_1 = $addMember->address_1;
			$address_2 = $addMember->address_2;
			$address_3 = $addMember->address_3;
			$postcode = $addMember->postcode;
			$county_id = $addMember->county_sel;
			if($county_id == 0) {
				$county_id = NULL;
			}
			$country_id = $addMember->country_sel;
			$contact_number = $addMember->contact_number;
		}
		else
		{
			$address_1 = $form->getValue('address_1');
			$address_2 = $form->getValue('address_2');
			$address_3 = $form->getValue('address_3');
			$postcode = $form->getValue('postcode');
			$county_id = $form->getValue('county_sel');
			if($county_id == 0) {
				$county_id = NULL;
			}
			$country_id = $form->getValue('country_sel');
			$contact_number = $form->getValue('contact_number');
		}
		
		$data = array(
			'address_1' => $address_1,
			'address_2' => $address_2,
			'address_3' => $address_3,
			'postcode' => $postcode,
			'county_id' => $county_id,
			'country_id' => $country_id,
			'contact_number' => $contact_number,
		);
		
		$office_address_tbl = new Application_Model_DbTable_OfficeAddress();	
		$company_office_address_tbl = new Application_Model_DbTable_CompanyOfficeAddress();
		
		$office_address_tbl->addOfficeAddress($data);
		$office_address = $office_address_tbl->getLastEntered();
		$office_address_id = $office_address['id'];
		$company_office_address_tbl->addCompanyOfficeAddress(array('company_id' => $c_id, 'office_address_id' => $office_address_id, 'address_type' => $office_type));
				
	}
	
	
	public function updateOffice($c_id, $form, $office_type) {
			
		$address_1 = $form->getValue('address_1');
		$address_2 = $form->getValue('address_2');
		$address_3 = $form->getValue('address_3');
		$postcode = $form->getValue('postcode');
		$county_id = $form->getValue('county_sel');
		if($county_id == 0) {
			$county_id = NULL;
		}
		$country_id = $form->getValue('country_sel');
		$contact_number = $form->getValue('contact_number');
		
		$data = array(
			'address_1' => $address_1,
			'address_2' => $address_2,
			'address_3' => $address_3,
			'postcode' => $postcode,
			'county_id' => $county_id,
			'country_id' => $country_id,
			'contact_number' => $contact_number,
		);
		
		$company_office_address_tbl = new Application_Model_DbTable_CompanyOfficeAddress();
		$office_address_id = $company_office_address_tbl->getOfficeAddressId($c_id, $office_type);
		$office_address_tbl = new Application_Model_DbTable_OfficeAddress();
		
		if($office_address_id == NULL) {
			// no entry, so add a new one
			$office_address_tbl->addOfficeAddress($data);
			$office_address = $office_address_tbl->getLastEntered();
			$office_address_id = $office_address['id'];
			$company_office_address_tbl->addCompanyOfficeAddress(array('company_id' => $c_id, 'office_address_id' => $office_address_id, 'address_type' => $office_type));
		} else {
			// just update
			$office_address_tbl->updateOfficeAddress($data, $office_address_id);
		}
				
	}
	
	
	public function savePreviousCompanyNames($c_id, $text) {
		
		$names = explode(",", $text);
		$prev_company_names = new Application_Model_DbTable_CompanyPrevNames();
		
		foreach($names as $name) {
			$prev_company_names->addCompanyPrevName(array('company_id' => $c_id, 'prev_name' => $name));
		}
		
	}
	
	public function saveOtherWebsites($c_id, $text) {
		
		$websites = explode(",", $text);
		$other_websites = new Application_Model_DbTable_CompanyOtherWebsites();
		
		foreach($websites as $website) {
			$other_websites->addCompanyOtherWebsite(array('company_id' => $c_id, 'url' => $website));
		}
		
	}
	
	// determines whether or not the minimum amount of fields have been filled in
	public function officeFields($form) {
		
		$insert; // boolean var
		
		$address_1 = $form->getValue('address_1');
		$county_id = $form->getValue('county_sel');
		$country_id = $form->getValue('country_sel');
		// all above fields have to be set in order to return true
		if(
			(isset($address_1) && $address_1 != '') &&
			(isset($county_id) && $county_id != '') &&
			(isset($country_id) && $country_id != '')
		  )
		{
			$insert = true;
		} else {
			$insert = false;
		}
		
		return $insert;
		
	}
	
	// determines whether or not the minimum amount of fields have been filled in
	public function officeVars() {
		
		Zend_Session::start();
		$addMember = new Zend_Session_Namespace('addMember');
		
		$insert; // boolean var
		
		$address_1 = $addMember->address_1;
		$county_id = $addMember->county_sel;
		$country_id = $addMember->country_sel;
		// all above fields have to be set in order to return true
		if(
			(isset($address_1) && $address_1 != '') &&
			(isset($county_id) && $county_id != '') &&
			(isset($country_id) && $country_id != '')
		  )
		{
			$insert = true;
		} else {
			$insert = false;
		}
		
		return $insert;
		
	}
		
	
	public function update($form, $c_id)
	{
		
		$current_company_name = $form->getValue('current_company_name');
		$company_website = $form->getValue('company_website');
		$number_of_employees_id = $form->getValue('num_employees_sel');
		$sector_id = $form->getValue('sector_sel');
		
		$data = array(
			'current_company_name' => $current_company_name,
			'company_website' => $company_website,
			'number_of_employees_id' => $number_of_employees_id,
			'sector_id' => $sector_id,
		);
		
		$company = new Application_Model_DbTable_Company();
		$comp_profile = $company->getCompany($c_id);
		$comp_curr_name = $comp_profile['current_company_name'];
		
		$company->updateCompany($data, $c_id);
		
		if($current_company_name != $comp_curr_name) { //user has changed the current company name in the form
			// enter old current_company_name into the previous company names table as a new record
			$comp_prev_names_tbl = new Application_Model_DbTable_CompanyPrevNames();
			$comp_prev_names = $comp_prev_names_tbl->getCompanyPrevNames($c_id);
			$exists; // var to store whether current_company_name in form already exists in prev company names table
			foreach($comp_prev_names as $comp_prev_name) {
				if($current_company_name == $comp_prev_name['prev_name']) {
					$exists = TRUE;
					// delete record from prev company names table as it's same as updated current company name
					$comp_prev_names_tbl->delete('company_id = ' . $c_id . ' and prev_name = ' . "'" . $comp_prev_name['prev_name'] . "'");
					break;		
				}
			}
			if(!$exists) {
				$comp_prev_names_tbl->addCompanyPrevName(array('company_id' => $c_id, 'prev_name' =>$comp_curr_name));
			}
		}
	}


	public function updatePrevCompanyNames($text, $c_id) {
		// Will approach this function later, as it's implications are large
		// e.g.: When adding a new member, if nomination name differs from current company name,
		// nomination name is entered as a previous company name for that company in "company_previous_company_names" table
		// so being able to edit or delete previous company names has implications on both company and member
		// and the overall flow of how it would work between members and companies would have to be
		// carefully looked at. Previous company names would probably have to be made editable seperately,
		// as opposed to having them editable in a text box, seperated by commas for example.
		// For now, due to time constraints, I am not attempting to
		// implementing this function for integrity and safety reasons.
		
	}
	
	
	public function updateOtherWebsites($text, $c_id) {
		// this function is not ideal currently. it is almost like a patch
		// the way in which company other websites are updated could be improved upon
		$company_other_websites = new Application_Model_DbTable_CompanyOtherWebsites();
		$other_websites = $company_other_websites->getCompanyOtherWebsites($c_id);
		
		$str = '';
		if($other_websites != NULL) { //this company has at least one entry in table
			if(isset($text) && $text != '') {
				//compare companyOtherWebsites in table with what's currently in the form
				foreach ($other_websites as $other_website) {
					$str .= $other_website['url'] . ',';
				}
				$str = substr($str, 0, strlen($str)-1); // chop off last comma
			
				if($text != $str) { // changes have been made in the form to the other websites
					$company_other_websites->deleteCompanyOtherWebsites($c_id); // delete record/s from table
					$this->saveOtherWebsites($c_id, $text); // add record/s to table
				} 
			} else { // no text in form for other websites
				$company_other_websites->deleteCompanyOtherWebsites($c_id); // delete record/s from table
			}
			
		} else { // no entry in table
			if(isset($text) && $text != '') {
				$this->saveOtherWebsites($c_id, $text); // add record/s to table
			}
		}
	}
	
		
	public function populateFormCompInfo($form, $c_id) {
		
		$company_tbl = new Application_Model_DbTable_Company();
		$previous_names_tbl = new Application_Model_DbTable_CompanyPrevNames();
		$other_websites_tbl = new Application_Model_DbTable_CompanyOtherWebsites();
		
		$company = $company_tbl->getCompany($c_id);
		$previous_names = $previous_names_tbl->getCompanyPrevNames($c_id);
		$other_websites = $other_websites_tbl->getCompanyOtherWebsites($c_id);
		
		// start of company details
		$form->current_company_name->setValue($company['current_company_name']);
    	$form->company_website->setValue($company['company_website']);
		
		// set number of employees drop down list
		$num_employees_id = $company['number_of_employees_id'];
		$form->num_employees_sel->setValue($num_employees_id);
		
		// set sector in sector drop down list
		$sector_id = $company['sector_id'];
		$form->sector_sel->setValue($sector_id);
		
		// set previous company names
		if($previous_names != NULL) {
			
			$str = '';
			foreach ($previous_names as $previous_name) {
				$str .= $previous_name['prev_name'] . ',';
			}
			// chop off last comma
			$str = substr($str, 0, strlen($str)-1); 
			$form->previous_company_names->setValue($str);
		}
		
		// set other website names
		if($other_websites != NULL) {
			
			$str = '';
			foreach ($other_websites as $other_website) {
				$str .= $other_website['url'] . ',';
			}
			// chop off last comma
			$str = substr($str, 0, strlen($str)-1); 
			$form->other_websites->setValue($str);
		}
		
	}
	
	
	public function populateFormOffice($form, $c_id, $office_type) {
		
		$company_office_address_tbl = new Application_Model_DbTable_CompanyOfficeAddress();
		$office_address_id = $company_office_address_tbl->getOfficeAddressId($c_id, $office_type);
		
		if($office_address_id != NULL) {
				
			$office_address_tbl = new Application_Model_DbTable_OfficeAddress();
			$office_address = $office_address_tbl->getOfficeAddress($office_address_id);
			
			// head office details
			if($office_address != NULL) {
				$form->address_1->setValue($office_address['address_1']);
				$form->address_2->setValue($office_address['address_2']);
				$form->address_3->setValue($office_address['address_3']);
				$form->postcode->setValue($office_address['postcode']);
				$form->county_sel->setValue($office_address['county_id']);
				$form->country_sel->setValue($office_address['country_id']);
				$form->contact_number->setValue($office_address['contact_number']);
			}
		}		
	}
	
	
}
