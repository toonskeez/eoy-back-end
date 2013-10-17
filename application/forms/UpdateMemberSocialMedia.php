<?php

class Application_Form_UpdateMemberSocialMedia extends Zend_Form
{

    public function init()
    {
        
		$this->setName('updateMemberSocialMedia');
		$this->setMethod('post');
		$this->setAttrib('enctype', 'multipart/form-data');
		
		$m_id = new Zend_Form_Element_Hidden('m_id');
		$m_id->setValue($_GET['m_id']);
		
		
		$social_media_linkedin_name = new Zend_Form_Element_Text('social_media_linkedin_name');
		$social_media_linkedin_name->setLabel('Linkedin Name')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$social_media_facebook_name = new Zend_Form_Element_Text('social_media_facebook_name');
		$social_media_facebook_name->setLabel('Facebook Name')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$social_media_skype_id = new Zend_Form_Element_Text('social_media_skype_id');
		$social_media_skype_id->setLabel('Skype ID')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$social_media_twitter_username = new Zend_Form_Element_Text('social_media_twitter_username');
		$social_media_twitter_username->setLabel('Twitter Username')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		$social_media_other = new Zend_Form_Element_Text('social_media_other');
		$social_media_other->setLabel('Other social media')
		->setRequired(false)
		->addFilter('StripTags')
		->addFilter('StringTrim');
		
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submit_btn_mem_socialmedia');
		
		$cancel = new Zend_Form_Element_Button('cancel');
		$cancel->setAttrib('id', 'cancel_btn_edit_member');
		
		$this->addElements(array($m_id, $social_media_linkedin_name, $social_media_facebook_name, $social_media_skype_id,
									$social_media_twitter_username, $social_media_other, $submit, $cancel));

    }
	

}

