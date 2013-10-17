<?php

class Application_Form_MemberSearch extends Zend_Form
{

    public function init()
    {
        	
        $this->setName('memberSearch');
		$this->setMethod('post');
		
		$name = new Zend_Form_Element_Text('name');
		$name->setLabel('Search by Name')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$county = new Application_Model_DbTable_County();
		$county_list = $county->getAll();
		$county_list = array_merge(array("0" => "choose county"), $county_list); 		
		$county_sel = new Zend_Form_Element_Select('county_sel');
		$county_sel->setAttrib('id', 'county_sel');
		$county_sel->setLabel('Irish County')
		->setMultiOptions($county_list)
		->setRequired(false);
		
		$country = new Application_Model_DbTable_Country();
		$country_list = $country->getAll();
		$country_list = array_merge(array("0" => "choose country"), $country_list);
		$country_sel = new Zend_Form_Element_Select('country_sel');
		$country_sel->setAttrib('id', 'country_sel');
		$country_sel->setLabel('International Offices')
		->setMultiOptions($country_list)
		->setRequired(false);
		
		$sector = new Application_Model_DbTable_Sector();
		$sector_list = $sector->getAll();
		$sector_list = array_merge(array("0" => "choose industry type"), $sector_list);
		$sector_sel = new Zend_Form_Element_Select('sector_sel');
		$sector_sel->setAttrib('id', 'sector_sel');
		$sector_sel->setLabel('Industry Type')
		->setMultiOptions($sector_list)
		->setRequired(false);
		
		$keyword = new Application_Model_DbTable_Keyword();
		$keyword_list = $keyword->getAll();
		
		$keyword_list = array_merge(array("0" => "choose keyword/s"), $keyword_list);
		$keyword_sel = new Zend_Form_Element_Select('keyword_sel');
		$keyword_sel->setAttrib('id', 'keyword_sel');
		$keyword_sel->setLabel('Keywords')
		->setMultiOptions($keyword_list)
		->setRequired(false);
		
		$number_of_employees = new Application_Model_DbTable_NumberOfEmployees();
		$number_of_employees_rowSetArray = $number_of_employees->fetchAll()->toArray();
		$number_of_employees_list = Array();
		
		foreach ($number_of_employees_rowSetArray as $rowArray) {
			$number_of_employees_list[] = Array('key' => $rowArray['id'], 'value' => $rowArray['min'] . ' - ' . $rowArray['max']);
		}	
		
		$number_of_employees_list = array_merge(array("0" => "choose number of employees"), $number_of_employees_list);
		
		$num_employees_sel = new Zend_Form_Element_Select('num_employees_sel');
		$num_employees_sel->setAttrib('id', 'num_employees_sel');
		$num_employees_sel->setLabel('Number of Employees')
		->setMultiOptions($number_of_employees_list)
		->setRequired(false);		
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		
		$cancel = new Zend_Form_Element_Button('cancel');
		$cancel->setAttrib('id', 'cancel_btn_search_member');
		
		$this->addElements(array($name, $county_sel, $country_sel, $sector_sel,
									$keyword_sel, $num_employees_sel, $submit, $cancel));
									
    }


}

