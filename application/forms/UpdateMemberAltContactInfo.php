<?php

class Application_Form_UpdateMemberAltContactInfo extends Zend_Form
{

    public function init()
    {
        
		$this->setName('updateMemberAltContactInfo');
		$this->setMethod('post');
		$this->setAttrib('enctype', 'multipart/form-data');
		
		$m_id = new Zend_Form_Element_Hidden('m_id');
		$m_id->setValue($_GET['m_id']);

		
		$alt_contact_full_name = new Zend_Form_Element_Text('alt_contact_full_name');
		$alt_contact_full_name->setLabel('Full Name *')
		->setRequired(true)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$alt_contact_business_title = new Zend_Form_Element_Text('alt_contact_business_title');
		$alt_contact_business_title->setLabel('Business title')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$alt_contact_direct_phone = new Zend_Form_Element_Text('alt_contact_direct_phone');
		$alt_contact_direct_phone->setLabel('Direct phone')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('Digits');
		
		$alt_contact_mobile_phone = new Zend_Form_Element_Text('alt_contact_mobile_phone');
		$alt_contact_mobile_phone->setLabel('Mobile phone')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('Digits');
		
		$alt_contact_other_phone = new Zend_Form_Element_Text('alt_contact_other_phone');
		$alt_contact_other_phone->setLabel('Other phone')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('Digits');
		
		$alt_contact_email = new Zend_Form_Element_Text('alt_contact_email');
		$alt_contact_email->setLabel('Email')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('EmailAddress', true);
		
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submit_btn_mem_altcontact');
		
		$cancel = new Zend_Form_Element_Button('cancel');
		$cancel->setAttrib('id', 'cancel_btn_edit_member');
		
		$this->addElements(array($m_id, $alt_contact_full_name, $alt_contact_business_title, $alt_contact_direct_phone,
									$alt_contact_mobile_phone, $alt_contact_other_phone, $alt_contact_email, $submit, $cancel));

    }
	

}

