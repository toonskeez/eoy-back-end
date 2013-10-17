<?php

class Application_Form_AddMemberPersonal extends Zend_Dojo_Form
{

    public function init()
    {
        	
        $this->setName('addMemberPersonal');
		$this->setMethod('post');
		$this->setAttrib('enctype', 'multipart/form-data');
		
		$m_id = new Zend_Form_Element_Hidden('m_id');
		$m_id->addFilter('Int');
		
		
		/***************  Member Fields  *****************/
		
		$salutation = new Zend_Form_Element_Text('salutation');
		$salutation->setLabel('Salutation')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$first_name = new Zend_Form_Element_Text('first_name');
		$first_name->setLabel('First Name *')
		->setRequired(true)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$middle_initial = new Zend_Form_Element_Text('middle_initial');
		$middle_initial->setLabel('Middle Initial')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$last_name = new Zend_Form_Element_Text('last_name');
		$last_name->setLabel('Last Name *')
		->setRequired(true)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$member_bio = new Zend_Form_Element_Textarea('member_bio');
		$member_bio->setLabel('Member Bio')
		->setRequired(false)
		->setAttrib('rows', '5')
		->setAttrib('maxlength', '1240')
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$member_other_info = new Zend_Form_Element_Textarea('member_other_info');
		$member_other_info->setLabel('Member Other info')
		->setRequired(false)
		->setAttrib('rows', '5')
		->setAttrib('maxlength', '990')
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$photo_uri = new Zend_Form_Element_File('photo_uri');
		$photo_uri->setLabel('Select new profile picture')
		->setRequired(false)
		->setDestination(PUBLIC_PATH . '/images/profile_pics')
		//->addValidator('IsImage', true)
		//->addValidator('Extension', false, 'jpg,png,gif')
        //->addValidator('MimeType', false, array('image/jpeg',  'image/png', 'image/gif'))
		->addValidator('Size', false, 1024000); // 1MB
		
		$deceased = new Zend_Form_Element_Radio('deceased');
		$deceased->setAttrib('id', 'deceased');
		$arr = array('0' => 'no', '1' => 'yes');
		$deceased->setMultiOptions($arr)
		->setLabel('Deceased?')
		->setRequired(true);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submit_btn_mem_pers');
		
		$cancel = new Zend_Form_Element_Button('cancel');
		$cancel->setAttrib('id', 'cancel_btn_add_member');
		
		$this->addElements(array($m_id, $salutation, $first_name, $middle_initial, $last_name,
									$member_bio, $member_other_info, $photo_uri, $deceased, $submit, $cancel));
									
    }


}

