<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
       
    }

    public function indexAction()
    {
		
    }
	
	
	public function memberAction() {
		
		Zend_Session::start();
		// following two lines necessary in the case that user has entered some member data
		// while adding new member and then clicked 'cancel' button.
		// without following two lines, if user decides to add new user, previously entered
		// data would still remain in the form fields which is not desirable
		$addMember = new Zend_Session_Namespace('addMember');
		$addMember->unsetAll(); // clear all session vars in the addMember namespace
		
		$addMemberForms = new Zend_Session_Namespace('addMemberForms');
		$addMemberForms->personal = array('name' => 'Personal Details', 'complete' => false);
		$addMemberForms->professional = array('name' => 'Professional Details', 'complete' => false);
		$addMemberForms->nomCompany = array('name' => 'Nomination Company', 'complete' => false);
		$addMemberForms->contact = array('name' => 'Contact Details', 'complete' => false);
		$addMemberForms->altContact = array('name' => 'Alternative Contact', 'complete' => false);
		$addMemberForms->socialMedia = array('name' => 'Social Media', 'complete' => false);
		
		$member_profiles = new Application_Model_DbTable_MemberCompanyHeadofficeView();
		$this->view->member_profiles = $member_profiles->fetchAll();
		
	}
	
	
	public function companyAction() {
		
		$companies = new Application_Model_DbTable_CompanyDetailsView();
		$this->view->companies = $companies->fetchAll();
		
	}

    
	public function addmemberAction()
    {
        Zend_Session::start();
		$addMember = new Zend_Session_Namespace('addMember');
		$addMemberForms = new Zend_Session_Namespace('addMemberForms');
		
        $form = new Application_Form_AddMemberProfile();
		$form->submit->setLabel('Save Member Profile');
		$form->setDecorators(array(array('ViewScript', array('script' => 'addmember.phtml'))));
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			
			$personal = $addMemberForms->personal;
			$professional = $addMemberForms->professional;
			$nomCompany = $addMemberForms->nomCompany;
			$contact = $addMemberForms->contact;
			
			$forms = array($personal, $professional, $nomCompany, $contact);
			
			$requiredForms = true;

			$msg = '<script type="text/javascript">window.alert("';
			$msg .= 'Please complete all required forms\nThe following required forms are not complete\n\n';
			
			foreach($forms as $form) {
				if($form['complete'] == false) {
					$requiredForms = false;
					$msg .= $form['name'] . '\n';
				}
			}

			$msg .= '");</script>';
			
			if ($requiredForms) {
				
				$member_tbl = new Application_Model_DbTable_MemberProfile();
				$company_tbl = new Application_Model_DbTable_Company();
				$member_company_tbl = new Application_Model_DbTable_MemberCompany();
				$member_service = new Application_Service_Member();
				$company_service = new Application_Service_Company();
				$c_id;
				$company_type = $addMember->company_type;
				
				$member_service->save();
				$member = $member_tbl->getLastEntered();
				$m_id = $member['id'];
				
				if($company_type == 'existing') {
									
					$c_id = $addMember->company_sel;				
									
				} else { // company_type == 'new'
					// add the new company into the company table,
					$company_service->save(NULL); // save company and get company id
					//get company id from last entry in company table
					//need this for entries into other company-linked tables
					$company = $company_tbl->getLastEntered();
					$c_id = $company['id'];
					
					if($company_service->officeVars()) {
						$company_service->saveOffice($c_id, NULL, 'head');
					}
				
					$prev_company_names = $addMember->previous_company_names;
					if(isset($prev_company_names) && $prev_company_names != '') {
						$company_service->savePreviousCompanyNames($c_id, $prev_company_names);
					}
					
					//company is new, so if nomination company name different from current company name
					//check if user has entered nomination company name as a previous company name
					//by way of querying the db table. if not, enter it as a previous company name
					$nomination_company_name = $addMember->nomination_company_name;
					$current_company_name = $addMember->current_company_name;
					
					if((isset($nomination_company_name) && $nomination_company_name != '')
						&& (isset($current_company_name) && $current_company_name != ''))
					{
						if($nomination_company_name != $current_company_name) {
							$comp_prev_names = new Application_Model_DbTable_CompanyPrevNames();
						
							if($comp_prev_names->nameExists($c_id, $nomination_company_name) == FALSE) {
								$company_service->savePreviousCompanyNames($c_id, $nomination_company_name);
							}
						}		
					}
								
				
					$other_websites = $addMember->other_websites;
					if(isset($other_websites) && $other_websites != '') {
						$company_service->saveOtherWebsites($c_id, $other_websites);
					}
				}
				
				$member_company_tbl->addMemberCompany(array('member_id' => $m_id, 'company_id' => $c_id, 'company_type' => 'nomination'));
				
				if($member_service->altContactVars()) { // check if relative field/s filled in
					// save alt contact details to member_alt_contact table
					$member_service->saveAltContact(NULL, $m_id);
				}
				
				$keywords = $addMember->keywords;
				if(isset($keywords)) {
					$member_service->saveKeywords($keywords, $m_id);
				}
				
				$prof_experience = $addMember->professional_experience;
				if(isset($prof_experience) && $prof_experience != '') {
					$member_service->saveProfExperience($prof_experience, $m_id);
				}
				
				$bio = $addMember->bio;
				if(isset($bio) && $bio != '') {
					$member_service->saveBio($bio, $m_id);
				}
				
				if($member_service->socialMediaVars()) { // check if relative field/s filled in
					$member_service->saveSocialMedia(NULL, $m_id);
				}
				
				$other_companies = $addMember->other_companies;
				if(isset($other_companies) && $other_companies != '') {
					$member_service->saveOtherCompanies($other_companies, $m_id);
				}
				
				$other_info = $addMember->other_info;
				if(isset($other_info) && $other_info != '') {
					$member_service->saveOtherInfo($other_info, $m_id);
				}
				
				$addMember->unsetAll(); // clear all session vars in the addMember namespace
				$addMemberForms->unsetAll(); // clear all session vars in the addMemberForms namespace
				$this->_helper->redirector('member');
				
			} else {
				$this->view->msg = $msg; // alerts user that they have forms to fill in
			}
		}
		
    } // end of addAction
	
	
	public function addmemberpersonalAction()
	{		
		$member_service = new Application_Service_Member();
		$this->view->member_service = $member_service;
		$form = new Application_Form_AddMemberPersonal();
		$form->submit->setLabel('Save');
		$form->setDecorators(array(array('ViewScript', array('script' => 'addmemberpersonal.phtml'))));
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			if ($form->isValid($formData)) {
				
				$member_service = new Application_Service_Member();
				$member_service->storePersonalDetails($form);
				
				Zend_Session::start();
				$addMemberForms = new Zend_Session_Namespace('addMemberForms');				
				$addMemberForms->personal['complete'] = true; // save form as being completed
				
				$this->_helper->redirector('addmember');
				
			} else {
				$member_service->populateFormAddMemPersonal($form);
			}
		}
	}
	
	
	public function addmemberprofessionalAction()
	{		
		$member_service = new Application_Service_Member();
		$this->view->member_service = $member_service;
		$form = new Application_Form_AddMemberProfessional();
		$form->submit->setLabel('Save');
		$form->setDecorators(array(array('ViewScript', array('script' => 'addmemberprofessional.phtml'))));
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			if ($form->isValid($formData)) {
				
				$member_service = new Application_Service_Member();
				$member_service->storeProfessionalDetails($form);
				
				Zend_Session::start();
				$addMemberForms = new Zend_Session_Namespace('addMemberForms');				
				$addMemberForms->professional['complete'] = true; // save form as being completed
				
				$this->_helper->redirector('addmember');
				
			} else {
				$member_service->populateFormAddMemProfessional($form);
			}
		}
	}
	
	
	public function addmembernomcompanyAction()
	{		
		$member_service = new Application_Service_Member();
		$this->view->member_service = $member_service;
		$form = new Application_Form_AddMemberNominationCompany();
		$form->submit->setLabel('Save');
		$form->setDecorators(array(array('ViewScript', array('script' => 'addmembernomcompany.phtml'))));
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			if ($form->isValid($formData)) {
				
				$member_service = new Application_Service_Member();
				$member_service->storeNomCompanyDetails($form);
				
				Zend_Session::start();
				$addMemberForms = new Zend_Session_Namespace('addMemberForms');				
				$addMemberForms->nomCompany['complete'] = true; // save form as being completed
				
				$this->_helper->redirector('addmember');
				
			} else {
				$member_service->populateFormAddMemNomCompany($form);
			}
		}
	}
	
	
	public function addmembercontactAction()
	{		
		$member_service = new Application_Service_Member();
		$this->view->member_service = $member_service;
		$form = new Application_Form_AddMemberContactInfo();
		$form->submit->setLabel('Save');
		$form->setDecorators(array(array('ViewScript', array('script' => 'addmembercontact.phtml'))));
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			if ($form->isValid($formData)) {
				
				$member_service = new Application_Service_Member();
				$member_service->storeContactDetails($form);
				
				Zend_Session::start();
				$addMemberForms = new Zend_Session_Namespace('addMemberForms');				
				$addMemberForms->contact['complete'] = true; // save form as being completed
				
				$this->_helper->redirector('addmember');
				
			} else {
				$member_service->populateFormAddMemContact($form);
			}
		}
	}
	
	
	public function addmemberaltcontactAction()
	{		
		$member_service = new Application_Service_Member();
		$this->view->member_service = $member_service;
		$form = new Application_Form_AddMemberAltContactInfo();
		$form->submit->setLabel('Save');
		$form->setDecorators(array(array('ViewScript', array('script' => 'addmemberaltcontact.phtml'))));
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			if ($form->isValid($formData)) {
				
				$member_service = new Application_Service_Member();
				$member_service->storeAltContactDetails($form);
				
				Zend_Session::start();
				$addMemberForms = new Zend_Session_Namespace('addMemberForms');				
				$addMemberForms->altContact['complete'] = true; // save form as being completed
				
				$this->_helper->redirector('addmember');
				
			} else {
				$member_service->populateFormAddMemAltContact($form);
			}
		}
	}
	
	
	public function addmembersocmediaAction()
	{		
		$member_service = new Application_Service_Member();
		$this->view->member_service = $member_service;
		$form = new Application_Form_AddMemberSocialMedia();
		$form->submit->setLabel('Save');
		$form->setDecorators(array(array('ViewScript', array('script' => 'addmembersocmedia.phtml'))));
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			if ($form->isValid($formData)) {
				
				$member_service = new Application_Service_Member();
				$member_service->storeSocialMediaDetails($form);
				
				Zend_Session::start();
				$addMemberForms = new Zend_Session_Namespace('addMemberForms');				
				$addMemberForms->socialMedia['complete'] = true; // save form as being completed
				
				$this->_helper->redirector('addmember');
				
			} else {
				$member_service->populateFormAddMemSocMedia($form);
			}
		}
	}
	
	
    public function editmemberAction()
    {
        $this->view->member_tbl = new Application_Model_DbTable_MemberProfile();
		$this->view->company_tbl = new Application_Model_DbTable_Company();
		$this->view->member_company_tbl = new Application_Model_DbTable_MemberCompany();
		
        $form = new Application_Form_UpdateMemberProfile();
		$form->setDecorators(array(array('ViewScript', array('script' => 'editmember.phtml'))));
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			if ($form->isValid($formData)) {				
				$this->_helper->redirector('member');
			} else {
				$form->populate($formData);
			}
		}
		
    } // end of editAction
    
    
    public function editmemberpersonalAction()
    {
        $this->view->member_tbl = new Application_Model_DbTable_MemberProfile();
        $this->view->member_service = new Application_Service_Member();
		
        $form = new Application_Form_UpdateMemberPersonal();
		$form->submit->setLabel('Save Details');
		$form->setDecorators(array(array('ViewScript', array('script' => 'editmemberpersonal.phtml'))));
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			if ($form->isValid($formData)) {
				
				$m_id = (int)$this->getParam('m_id', 0); // cast to integer
				
				if($m_id > 0) {
					$member_service = new Application_Service_Member();
					$member_service->updateMemberPersonal($form, $m_id);
				}
				
				$this->_helper->redirector('editmember');
			} else {
				$form->populate($formData);
			}
		}
		
    } // end of editAction
    
    
    public function editmemberprofessionalAction()
    {
        $this->view->member_tbl = new Application_Model_DbTable_MemberProfile();
        $this->view->member_service = new Application_Service_Member();
		
        $form = new Application_Form_UpdateMemberProfessional();
		$form->submit->setLabel('Save Details');
		$form->setDecorators(array(array('ViewScript', array('script' => 'editmemberprofessional.phtml'))));
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			if ($form->isValid($formData)) {
				
				$m_id = (int)$this->getParam('m_id', 0); // cast to integer
				
				if($m_id > 0) {
					$member_service = new Application_Service_Member();
					$member_service->updateMemberProfessional($form, $m_id);	
				}
				
				$this->_helper->redirector('editmember');
			} else {
				$form->populate($formData);
			}
		}
		
    } // end of editAction
    
    
    public function memeditcompanyAction() {
			
		$this->view->company_tbl = new Application_Model_DbTable_Company();
		
		$form = new Application_Form_UpdateCompany();
		$form->setDecorators(array(array('ViewScript', array('script' => 'memeditcompany.phtml'))));
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			if ($form->isValid($formData)) {
				$this->_helper->redirector('memeditcompany');		
			} else {
				$form->populate($formData);
			}
		}
		
    } // end of function
    
    
    public function editmembercontactAction()
    {
        $this->view->member_tbl = new Application_Model_DbTable_MemberProfile();
        $this->view->member_service = new Application_Service_Member();
		
        $form = new Application_Form_UpdateMemberContactInfo();
		$form->submit->setLabel('Save Details');
		$form->setDecorators(array(array('ViewScript', array('script' => 'editmembercontact.phtml'))));
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			if ($form->isValid($formData)) {
				
				$m_id = (int)$this->getParam('m_id', 0); // cast to integer
				
				if($m_id > 0) {
					$member_service = new Application_Service_Member();
					$member_service->updateMemberContact($form, $m_id);	
				}
				
				$this->_helper->redirector('editmember');
			} else {
				$form->populate($formData);
			}
		}
		
    } // end of editAction
    

    public function editmemberaltcontactAction()
    {
        $this->view->member_tbl = new Application_Model_DbTable_MemberProfile();
        $this->view->member_service = new Application_Service_Member();
		
        $form = new Application_Form_UpdateMemberAltContactInfo();
		$form->submit->setLabel('Save Details');
		$form->setDecorators(array(array('ViewScript', array('script' => 'editmemberaltcontact.phtml'))));
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			if ($form->isValid($formData)) {
				
				$m_id = (int)$this->getParam('m_id', 0); // cast to integer
				
				if($m_id > 0) {
					$member_service = new Application_Service_Member();
					$member_service->updateAltContact($form, $m_id);	
				}
				
				$this->_helper->redirector('editmember');
			} else {
				$form->populate($formData);
			}
		}
		
    } // end of editAction
    
    
    public function editmembersocmediaAction()
    {
        $this->view->member_tbl = new Application_Model_DbTable_MemberProfile();
        $this->view->member_service = new Application_Service_Member();
		
        $form = new Application_Form_UpdateMemberSocialMedia();
		$form->submit->setLabel('Save Details');
		$form->setDecorators(array(array('ViewScript', array('script' => 'editmembersocmedia.phtml'))));
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			if ($form->isValid($formData)) {
				
				$m_id = (int)$this->getParam('m_id', 0); // cast to integer
				
				if($m_id > 0) {
					$member_service = new Application_Service_Member();
					$member_service->updateSocialMedia($form, $m_id);	
				}
				
				$this->_helper->redirector('editmember');
			} else {
				$form->populate($formData);
			}
		}
		
    } // end of editAction
    
    
    public function deletememberAction()
    {

    } // end of deleteAction
    
    
    public function addcompanyAction() {
		
		$form = new Application_Form_AddCompany();
		$form->submit->setLabel('Add Company');
		$form->setDecorators(array(array('ViewScript', array('script' => 'addcompany.phtml'))));
		$this->view->form = $form;
		
		$company_tbl = new Application_Model_DbTable_Company();
		$company_service = new Application_Service_Company();
		$company_id;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			if ($form->isValid($formData)) {
				
				$company_service->save($form);
				$company = $company_tbl->getLastEntered();
				$c_id = (int)$company['id'];
				$company_service->saveOffice($c_id, $form, 'head');
				
				$prev_company_names = $form->getValue('previous_company_names');
				if(isset($prev_company_names) && $prev_company_names != '') {
					$company_service->savePreviousCompanyNames($c_id, $prev_company_names);
				}
				
				$other_websites = $form->getValue('other_websites');
				if(isset($other_websites) && $other_websites != '') {
					$company_service->saveOtherWebsites($c_id, $other_websites);
				}
				
				$this->_helper->redirector('company');
				
			} else {
				$form->populate($formData);
			}
		}
		
	} // end of function
	
	
	public function memaddcompanyAction() {
		
		$form = new Application_Form_AddCompany();
		$form->submit->setLabel('Add Company');
		$form->setDecorators(array(array('ViewScript', array('script' => 'memaddcompany.phtml'))));
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			if ($form->isValid($formData)) {
					
				$member_company = new Application_Model_DbTable_MemberCompany();
				$company_service = new Application_Service_Company();
				$company_tbl = new Application_Model_DbTable_Company();
				
				$company_service->save($form);
				$company = $company_tbl->getLastEntered();
				$c_id = (int)$company['id'];
				
				$company_service->saveOffice($c_id, $form, 'head');
				
				$prev_company_names = $form->getValue('previous_company_names');
				if(isset($prev_company_names) && $prev_company_names != '') {
					$company_service->savePreviousCompanyNames($c_id, $prev_company_names);
				}
				
				$other_websites = $form->getValue('other_websites');
				if(isset($other_websites) && $other_websites != '') {
					$company_service->saveOtherWebsites($c_id, $other_websites);
				}
				
				$m_id = (int)$_REQUEST['m_id']; // member id
				if(isset($m_id) && isset($c_id)) {
					$member_company->addMemberCompany(array('member_id' => $m_id, 'company_id' => $c_id, 'company_type' => 'other'));
				}
				
				$this->_helper->redirector('editmember');
				
			} else {
				$form->populate($formData);
			}
		}
		
	} // end of function
    
    
    public function addcompanyinfoAction()
    {
        $form = new Application_Form_AddCompanyInfo();
		$form->submit->setLabel('Save Details');
		$form->setDecorators(array(array('ViewScript', array('script' => 'addcompanyinfo.phtml'))));
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			if ($form->isValid($formData)) {
							
				$company_tbl = new Application_Model_DbTable_Company();
				$company_service = new Application_Service_Company();
				$company_id;
				
				$company_service->save($form);
				$company = $company_tbl->getLastEntered();
				$company_id = $company['id'];				
				
				$prev_company_names = $form->getValue('previous_company_names');
				if(isset($prev_company_names) && $prev_company_names != '') {
					$company_service->savePreviousCompanyNames($company_id, $prev_company_names);
				}								
				
				$other_websites = $form->getValue('other_websites');
				if(isset($other_websites) && $other_websites != '') {
					$company_service->saveOtherWebsites($company_id, $other_websites);
				}
				
				$this->_helper->redirector('editcompany');
				
			} else {
				$form->populate($formData);
			}
		}
		
    } // end of addAction 
    
    
    public function editcompanyAction() {
    	
		$this->view->company_tbl = new Application_Model_DbTable_Company();
		
		$form = new Application_Form_UpdateCompany();
		$form->setDecorators(array(array('ViewScript', array('script' => 'editcompany.phtml'))));
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			if ($form->isValid($formData)) {
				
				$this->_helper->redirector('company');
					
			} else {
				$form->populate($formData);
			}
		}
		
    } // end of function
    
    
    public function editcompanyinfoAction() {
    	
		$this->view->company_tbl = new Application_Model_DbTable_Company();
        $this->view->company_service = new Application_Service_Company();
		
		$form = new Application_Form_UpdateCompanyInfo();
		$form->submit->setLabel('Save Details');
		$form->setDecorators(array(array('ViewScript', array('script' => 'editcompanyinfo.phtml'))));
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			if ($form->isValid($formData)) {
				
				$c_id = (int)$this->getParam('c_id', 0); // cast to integer
				
				if($c_id > 0) {
					$company_service = new Application_Service_Company();
					$company_service->update($form, $c_id);
					$other_websites = $form->getValue('other_websites');
					$company_service->updateOtherWebsites($other_websites, $c_id);
				}

				$this->_helper->redirector('editcompany');
								
			} else {
				$form->populate($formData);
			}
		}
		
    } // end of function
    
        
    public function editcompanyofficeAction() {
    	
		$this->view->company_tbl = new Application_Model_DbTable_Company();
        $this->view->company_service = new Application_Service_Company();
		
		$form = new Application_Form_UpdateCompanyOffice();
		$form->submit->setLabel('Save Details');
		$form->setDecorators(array(array('ViewScript', array('script' => 'editcompanyoffice.phtml'))));
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			if ($form->isValid($formData)) {
				
				$c_id = (int)$this->getParam('c_id', 0); // cast to integer
				$office_type = $this->getParam('office_type');
				
				if($c_id > 0 && isset($office_type) && $office_type != '') {					
					$company_service = new Application_Service_Company();
					$company_service->updateOffice($c_id, $form, $office_type);
				}
								
				$this->_helper->redirector('editcompany');			
				
			} else {
				$form->populate($formData);
			}
		}
		
    } // end of function
    
	
}







