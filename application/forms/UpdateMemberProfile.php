<?php

class Application_Form_UpdateMemberProfile extends Zend_Form
{

    public function init()
    {
        
		$this->setName('updateMemberProfile');
		$this->setMethod('post');
		$this->setAttrib('enctype', 'multipart/form-data');
		
		$m_id = new Zend_Form_Element_Hidden('m_id');
		$m_id->setValue($_GET['m_id']);
		/*
		$cancel = new Zend_Form_Element_Button('cancel');
		$cancel->setAttrib('id', 'cancel_btn');
		*/
		$this->addElements(array($m_id));

    }
	

}

