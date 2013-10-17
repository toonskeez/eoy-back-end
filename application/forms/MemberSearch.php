<?php

class Application_Form_MemberSearch extends Zend_Form
{

    public function init()
    {
        	
        $this->setName('memberSearch');
		$this->setMethod('post');
		
		$name = new Zend_Form_Element_Text('name');
		$name->setLabel('Search by First Name')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$search_type = new Zend_Form_Element_Radio('search_type');
		$search_type->setAttrib('id', 'search_type');
		$search_types = array('inclusive' => 'inclusive', 'exclusive' => 'exclusive');
		$search_type->setMultiOptions($search_types)
		->setLabel('Search Type')
		->setRequired(true)
		->setValue('inclusive');	
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		
		$cancel = new Zend_Form_Element_Button('cancel');
		$cancel->setAttrib('id', 'cancel_btn_search_member');
		
		$this->addElements(array($name, $search_type, $submit, $cancel));
									
    }


}

