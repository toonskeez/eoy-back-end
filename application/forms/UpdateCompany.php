<?php

class Application_Form_UpdateCompany extends Zend_Form
{

    public function init()
    {
        	
        $this->setName('UpdateCompany');
		$this->setMethod('post');
		
		$c_id = new Zend_Form_Element_Hidden('c_id');
		$c_id->setValue($_GET['c_id']);
		/*
		$cancel = new Zend_Form_Element_Button('cancel');
		$cancel->setAttrib('id', 'cancel_btn');
		*/
		$this->addElements(array($c_id));
									
    }
	
}

