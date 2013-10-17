<?php

class Application_Form_AddMemberProfile extends Zend_Dojo_Form
{

    public function init()
    {
        	
        $this->setName('addMemberProfile');
		$this->setMethod('post');
		$this->setAttrib('enctype', 'multipart/form-data');
		
		$m_id = new Zend_Form_Element_Hidden('m_id');
		$m_id->addFilter('Int');
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submit_btn_add_member');
		
		$cancel = new Zend_Form_Element_Button('cancel');
		$cancel->setAttrib('id', 'cancel_btn_add_member_main');
		
		$this->addElements(array($m_id, $submit, $cancel));
									
    }


}

