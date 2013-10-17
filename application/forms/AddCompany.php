<?php

class Application_Form_AddCompany extends Zend_Form
{

    public function init()
    {
        	
        $this->setName('addCompany');
		$this->setMethod('post');
		
		$m_id = new Zend_Form_Element_Hidden('m_id');
		$m_id->addFilter('Int');
		
		$current_company_name = new Zend_Form_Element_Text('current_company_name');
		$current_company_name->setLabel('Current Company Name *')
		->setRequired(true)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$company_website = new Zend_Form_Element_Text('company_website');
		$company_website->setLabel('Company Website *')
		->setRequired(true)
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
		
		/* OFFICE ADDRESS */
		
		$address_1 = new Zend_Form_Element_Text('address_1');
		$address_1->setLabel('Address 1 *')
		->setRequired(true)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$address_2 = new Zend_Form_Element_Text('address_2');
		$address_2->setLabel('Address 2')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$address_3 = new Zend_Form_Element_Text('address_3');
		$address_3->setLabel('Address 3')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$postcode = new Zend_Form_Element_Text('postcode');
		$postcode->setLabel('Postcode')
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
		$country_sel->setLabel('Country *')
		->setMultiOptions($country_list)
		->setRequired(true);
		
		$contact_number = new Zend_Form_Element_Text('contact_number');
		$contact_number->setLabel('Contact Number')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('Digits');
		
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submit_btn_add_company');
		
		$cancel = new Zend_Form_Element_Button('cancel');
		$cancel->setAttrib('id', 'cancel_btn_add_company');
		
		$this->addElements(array($m_id, $current_company_name, $company_website, $num_employees_sel,
									$sector_sel, $previous_company_names, $other_websites,
									$address_1, $address_2, $address_3,
									$postcode, $county_sel, $country_sel,
									$contact_number, $submit, $cancel));
									
    }


}

