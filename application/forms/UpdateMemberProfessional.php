<?php

class Application_Form_UpdateMemberProfessional extends Zend_Form
{

    public function init()
    {
        
		$this->setName('updateMemberProfessional');
		$this->setMethod('post');
		$this->setAttrib('enctype', 'multipart/form-data');
		
		$m_id = new Zend_Form_Element_Hidden('m_id');
		$m_id->setValue($_GET['m_id']);

		
		$business_title = new Zend_Form_Element_Text('business_title');
		$business_title->setLabel('Business Title')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$first_year_eoy_finalist = new Zend_Form_Element_Text('first_year_eoy_finalist');
		$first_year_eoy_finalist->setLabel('First Year EOY Finalist *')
		->setRequired(true)
		->addFilter('StripTags')
		->addFilter('StringTrim')
		->addValidator('Digits')
		->setAttrib('size', '4'); // it's a year, so limit input to 4 digits		
		
		$member_other_companies = new Zend_Form_Element_Text('member_other_companies');
		$member_other_companies->setLabel('Member: Other Companies (seperated by commas)')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$professional_experience = new Zend_Form_Element_Textarea('professional_experience');
		$professional_experience->setLabel('Professional Experience')
		->setRequired(false)
		->setAttrib('rows', '5')
		->setAttrib('maxlength', '760')
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$keyword = new Application_Model_DbTable_Keyword();
		$keyword_list = $keyword->getAll();
		
		$keyword_sel = new Zend_Form_Element_Multiselect('keyword_sel');
		$keyword_sel->setAttrib('id', 'keyword_sel');
		$keyword_sel->setLabel('Keywords')
		->setMultiOptions($keyword_list)
		->setRequired(false);
		
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submit_btn_mem_prof');
		
		$cancel = new Zend_Form_Element_Button('cancel');
		$cancel->setAttrib('id', 'cancel_btn_edit_member');
		
		$this->addElements(array($m_id, $business_title, $first_year_eoy_finalist, $member_other_companies,
									$professional_experience, $keyword_sel, $submit, $cancel));

    }
	

}

