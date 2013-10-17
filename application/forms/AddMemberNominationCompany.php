<?php

class Application_Form_AddMemberNominationCompany extends Zend_Dojo_Form
{

    public function init()
    {
        	
        $this->setName('addMemberNominationCompany');
		$this->setMethod('post');
		$this->setAttrib('enctype', 'multipart/form-data');
		
		$m_id = new Zend_Form_Element_Hidden('m_id');
		$m_id->addFilter('Int');
		
		 
		$nomination_company_name = new Zend_Form_Element_Text('nomination_company_name');
		$nomination_company_name->setLabel('Enter Nomination Company Name *')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		 
		$company_names_view = new Application_Model_DbTable_CompanyNamesView();
		$company_names_view_rowSetArray = $company_names_view->fetchAll()->toArray();
		
		$company_names_view_list = Array();
		
		$index = 0;
		$unique = 0; // used to keep the 'value' property of each option in select list unique
		foreach ($company_names_view_rowSetArray as $rowArray) {
			if($rowArray['curr_company_name'] !=  $company_names_view_rowSetArray[$index-1]['curr_company_name']) {
				$company_names_view_list[] = Array('key' => $rowArray['id'] . '-'. $unique . '-' . $rowArray['curr_company_name'], 'value' => $rowArray['curr_company_name']);
			}
			if($rowArray['prev_company_name'] != null) {
				$company_names_view_list[] = Array('key' => $rowArray['id'] . '-'. ++$unique . '-' . $rowArray['prev_company_name'], 'value' => $rowArray['prev_company_name']);
			}
			$index++;
		}
		
		$company_names_view_sel = new Zend_Form_Element_Select('company_names_view_sel');
		$company_names_view_sel->setAttrib('id', 'company_names_view_sel');
		$company_names_view_sel->setLabel('Choose Nomination Company Name *')
		->setMultiOptions($company_names_view_list)
		->setRegisterInArrayValidator(false)
		->setRequired(false);
		
		$company_type = new Zend_Form_Element_Radio('company_type');
		$company_type->setAttrib('id', 'company_type');
		$company_types = array('new' => 'new', 'existing' => 'existing');
		$company_type->setMultiOptions($company_types)
		->setLabel('Company Type')
		->setRequired(true);
		
		$company = new Application_Model_DbTable_NominationCompanyNamesView();
		$company_list = $company->getAll();
		$company_sel = new Zend_Form_Element_Select('company_sel');
		$company_sel->setAttrib('id', 'company_sel');
		$company_sel->setLabel('Choose Company *')
		->setMultiOptions($company_list)
		->setRequired(false);
		
		$current_company_name = new Zend_Form_Element_Text('current_company_name');
		$current_company_name->setLabel('Current Company Name *')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$company_website = new Zend_Form_Element_Text('company_website');
		$company_website->setLabel('Company Website *')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$number_of_employees = new Application_Model_DbTable_NumberOfEmployees();
		$number_of_employees_rowSetArray = $number_of_employees->fetchAll()->toArray();
		$number_of_employees_list = Array();
		
		foreach ($number_of_employees_rowSetArray as $rowArray) {
			$number_of_employees_list[] = Array('key' => $rowArray['id'], 'value' => $rowArray['min'] . ' - ' . $rowArray['max']);
		}
		
		$number_of_employees_list = array_merge(array("0" => "choose number of employees"), $number_of_employees_list);
		
		$num_employees_sel = new Zend_Form_Element_Select('num_employees_sel');
		$num_employees_sel->setAttrib('id', 'num_employees_sel');
		$num_employees_sel->setLabel('Number of Employees *')
		->setMultiOptions($number_of_employees_list)
		->setRequired(false);
		
		$sector = new Application_Model_DbTable_Sector();
		$sector_list = $sector->getAll();
		$sector_list = array_merge(array("0" => "choose sector type"), $sector_list);
		$sector_sel = new Zend_Form_Element_Select('sector_sel');
		$sector_sel->setAttrib('id', 'sector_sel');
		$sector_sel->setLabel('Sector *')
		->setMultiOptions($sector_list)
		->setRequired(false);
		
		$previous_company_names = new Zend_Form_Element_Text('previous_company_names');
		$previous_company_names->setLabel('Previous Company Names (seperated by commas)')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$other_websites = new Zend_Form_Element_Text('other_websites');
		$other_websites->setLabel('Other Websites (seperated by commas)')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		/* HEAD OFFICE */
		
		$address_1 = new Zend_Form_Element_Text('address_1');
		$address_1->setLabel('Head Office: Address 1 *')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$address_2 = new Zend_Form_Element_Text('address_2');
		$address_2->setLabel('Head Office: Address 2')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$address_3 = new Zend_Form_Element_Text('address_3');
		$address_3->setLabel('Head Office: Address 3')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$postcode = new Zend_Form_Element_Text('postcode');
		$postcode->setLabel('Head Office: Postcode')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$county = new Application_Model_DbTable_County();
		$county_list = $county->getAll();
		
		$county_sel = new Zend_Form_Element_Select('county_sel');
		$county_sel->setAttrib('id', 'county_sel');
		$county_sel->setLabel('Head Office: County *')
		->setMultiOptions($county_list)
		->setRequired(false);
		
		$country = new Application_Model_DbTable_Country();
		$country_list = $country->getAll();
		$country_list = array_merge(array("0" => "choose country"), $country_list);
		
		$country_sel = new Zend_Form_Element_Select('country_sel');
		$country_sel->setAttrib('id', 'country_sel');
		$country_sel->setLabel('Head Office: Country *')
		->setMultiOptions($country_list)
		->setRequired(false);
		
		$contact_number = new Zend_Form_Element_Text('contact_number');
		$contact_number->setLabel('Head Office: Contact Number')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('Digits');
		
		/* End of HEAD OFFICE */
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submit_btn_add_member_nom_comp');
		
		$cancel = new Zend_Form_Element_Button('cancel');
		$cancel->setAttrib('id', 'cancel_btn_add_member');
		
		$this->addElements(array($m_id, $nomination_company_name_type, $nomination_company_name, $company_names_view_sel,
									$company_type, $company_sel, $current_company_name, $company_website, $num_employees_sel,
									$sector_sel, $previous_company_names, $other_websites,
									$address_1, $address_2, $address_3, $postcode, $county_sel,
									$country_sel, $contact_number, $submit, $cancel));
									
    }


}

