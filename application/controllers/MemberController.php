<?php

class MemberController extends Zend_Controller_Action
{

    public function init()
    {
       
    }

    public function indexAction()
    {
		
    }
	
	
	public function searchAction() {
		
		$results = new Zend_Session_Namespace('memberSearchResults');
		$results->unsetAll();
		
		$county = new Application_Model_DbTable_County();
		$county_list = $county->getAll();	
		unset($county_list[0]); // patch to get rid of the 'c' that is the first element of the array
		$this->view->county_list = $county_list;
		
		$region = new Application_Model_DbTable_Region();
		$region_list = $region->getAll();
		$this->view->region_list = $region_list;
		
		$sector = new Application_Model_DbTable_Sector();
		$sector_list = $sector->getAll();
		$this->view->sector_list = $sector_list;
		
		$keyword = new Application_Model_DbTable_Keyword();
		$keyword_list = $keyword->getAll();
		$this->view->keyword_list = $keyword_list;
		
		$number_of_employees = new Application_Model_DbTable_NumberOfEmployees();
		$number_of_employees_rowSetArray = $number_of_employees->fetchAll()->toArray();
		$number_of_employees_list = Array();
		
		foreach ($number_of_employees_rowSetArray as $rowArray) {
			$number_of_employees_list[] = Array('key' => $rowArray['id'], 'value' => $rowArray['min'] . ' - ' . $rowArray['max']);
		}	
		
		$this->view->number_of_employees_list = $number_of_employees_list;
		
		$form = new Application_Form_MemberSearch();
		$form->submit->setLabel('Member Search');
		$form->setDecorators(array(array('ViewScript', array('script' => 'search.phtml'))));
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();			
			if ($form->isValid($formData)) {
						
				$member_tbl = new Application_Model_DbTable_MemberProfile();
				$member_view_tbl = new Application_Model_DbTable_MemberCompanyHeadofficeView();
				
				$name = $form->getValue('name');
				$search_type = $form->getValue('search_type');
				$counties = $this->getRequest()->getParam('county');
				$regions = $this->getRequest()->getParam('region');
				$sectors = $this->getRequest()->getParam('sector');
				$keywords = $this->getRequest()->getParam('keyword');
				$num_employees = $this->getRequest()->getParam('numEmployees');
				
				$params = array('name' => $name, 'counties' => $counties, 'regions' => $regions,
									'sectors' => $sectors, 'keywords' => $keywords, 'num_employees' => $num_employees);
				
				$memberIds = NULL;
				if($search_type == 'inclusive') {
						
					$memberIds = $member_tbl->getMemberIdsByParamsInclusive($params);
				
				} elseif($search_type == 'exclusive') {
					
					$memberIds = $member_tbl->getMemberIdsByParamsExclusive($params);
					
				}

				
				if ($memberIds != NULL && sizeof($memberIds) > 0) {
					$members = $member_view_tbl->getMembersByIds($memberIds);
					$results = new Zend_Session_Namespace('memberSearchResults');
					$results->members = $members;
				}

				$this->_helper->redirector('results');
				
			} else {
				$form->populate($formData);
			}
		}
		
	}
	
	
	
	public function resultsAction() {
		
		$results = new Zend_Session_Namespace('memberSearchResults');
		$this->view->members = $results->members;
		$this->view->testMembers = $results->testMembers;
		
	}
	    
	
}







