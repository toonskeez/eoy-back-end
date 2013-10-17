<?php

class Application_Form_UpdateCompanyInfo extends Zend_Form
{

    public function init()
    {
        	
        $this->setName('UpdateCompanyInfo');
		$this->setMethod('post');
		
		$c_id = new Zend_Form_Element_Hidden('c_id');
		$c_id->setValue($_GET['c_id']);
		
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

		$num_employees_sel = new Zend_Form_Element_Select('num_employees_sel');
		$num_employees_sel->setAttrib('id', 'num_employees_sel');
		$num_employees_sel->setLabel('Number of Employees *')
		->setMultiOptions($number_of_employees_list)
		->setRequired(true);
		
		$sector = new Application_Model_DbTable_Sector();
		$sector_list = $sector->getAll();
		$sector_sel = new Zend_Form_Element_Select('sector_sel');
		$sector_sel->setAttrib('id', 'sector_sel');
		$sector_sel->setLabel('Sector *')
		->setMultiOptions($sector_list)
		->setRequired(true);
		
		$previous_company_names = new Zend_Form_Element_Text('previous_company_names');
		$previous_company_names->setLabel('Previous Company Names (seperated by commas)')
		->setRequired(false)
		->setAttrib('readonly', 'true')
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$other_websites = new Zend_Form_Element_Text('other_websites');
		$other_websites->setLabel('Other Websites (seperated by commas)')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submit_btn_add_comp_info');
		
		$cancel = new Zend_Form_Element_Button('cancel');
		$cancel->setAttrib('id', 'cancel_btn_edit_company');
		
		$this->addElements(array($c_id, $current_company_name, $company_website, $num_employees_sel,
									$sector_sel, $previous_company_names, $other_websites, $submit, $cancel));
									
    }


}

