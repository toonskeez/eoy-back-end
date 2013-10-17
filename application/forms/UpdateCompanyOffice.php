<?php

class Application_Form_UpdateCompanyOffice extends Zend_Form
{

    public function init()
    {
        	
        $this->setName('UpdateCompanyOffice');
		$this->setMethod('post');
		
		$c_id = new Zend_Form_Element_Hidden('c_id');
		$c_id->setValue($_GET['c_id']);

		
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
		$county_sel->setLabel('County *')
		->setMultiOptions($county_list)
		->setRequired(true);
		
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
		$submit->setAttrib('id', 'submit_btn_edit_comp_office');
		
		$cancel = new Zend_Form_Element_Button('cancel');
		$cancel->setAttrib('id', 'cancel_btn_edit_company');
		
		$this->addElements(array($c_id, $address_1, $address_2, $address_3, $postcode,
									$county_sel, $country_sel, $contact_number, $submit, $cancel));
									
    }


}

