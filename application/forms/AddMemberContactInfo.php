<?php

class Application_Form_AddMemberContactInfo extends Zend_Dojo_Form
{

    public function init()
    {
        	
        $this->setName('addMemberContactInfo');
		$this->setMethod('post');
		$this->setAttrib('enctype', 'multipart/form-data');
		
		$m_id = new Zend_Form_Element_Hidden('m_id');
		$m_id->addFilter('Int');
		
		
		$business_phone = new Zend_Form_Element_Text('business_phone');
		$business_phone->setLabel('Business phone *')
		->setRequired(true)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('Digits');
		
		$direct_phone = new Zend_Form_Element_Text('direct_phone');
		$direct_phone->setLabel('Direct phone')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('Digits');
		
		$office_direct_line = new Zend_Form_Element_Text('office_direct_line');
		$office_direct_line->setLabel('Office Direct Line')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('Digits');
		
		$home_landline = new Zend_Form_Element_Text('home_landline');
		$home_landline->setLabel('Home Landline')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('Digits');
		
		$mobile_phone = new Zend_Form_Element_Text('mobile_phone');
		$mobile_phone->setLabel('Mobile Phone')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('Digits');
		
		$email = new Zend_Form_Element_Text('email');
		$email->setLabel('Email *')
		->setRequired(true)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('EmailAddress', true);
		
		$email_other = new Zend_Form_Element_Text('email_other');
		$email_other->setLabel('Other email')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('EmailAddress', true);

		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submit_btn_add_mem_contact');
		
		$cancel = new Zend_Form_Element_Button('cancel');
		$cancel->setAttrib('id', 'cancel_btn_add_member');
		
		$this->addElements(array($m_id, $business_phone, $direct_phone, $office_direct_line, $home_landline,
									$mobile_phone, $email, $email_other, $submit, $cancel));
									
    }


}

