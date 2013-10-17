<?php

class Application_Service_Member {	
	
	public function save()
	{
		Zend_Session::start();
		$addMember = new Zend_Session_Namespace('addMember');	
			
		$salutation = $addMember->salutation;
		$first_name = $addMember->first_name;
		$middle_initial = $addMember->middle_initial;
		$last_name = $addMember->last_name;  
		$business_title = $addMember->business_title;
		$direct_phone = $addMember->direct_phone;
		$business_phone = $addMember->business_phone;
		$office_direct_line = $addMember->office_direct_line;
		$home_landline = $addMember->home_landline;
		$mobile_phone = $addMember->mobile_phone;
		$email = $addMember->email;
		$email_other = $addMember->email_other;
		$first_year_eoy_finalist = $addMember->first_year_eoy_finalist;
		$nomination_company_name = $addMember->nomination_company_name;
		$photo_uri = $addMember->photo_uri;
		$deceased = $addMember->deceased;
		
		$data = array(
			'salutation' => $salutation,
			'first_name' => $first_name,
			'middle_initial' => $middle_initial,
			'last_name' => $last_name,  
			'business_title' => $business_title,
			'direct_phone' => $direct_phone,
			'business_phone' => $business_phone,
			'office_direct_line' => $office_direct_line,
			'home_landline' => $home_landline,
			'mobile_phone' => $mobile_phone,
			'email' => $email,
			'email_other' => $email_other,
			'first_year_eoy_finalist' => $first_year_eoy_finalist,
			'nomination_company_name' => $nomination_company_name,  
			'photo_uri' => "images/profile_pics/" .  $photo_uri,
			'deceased' => $deceased,
		);
		
		$member_profile	= new Application_Model_DbTable_MemberProfile();
		$member_profile->addMemberProfile($data);
		
	}
	
	
	public function storePersonalDetails($form) {
		
		Zend_Session::start();
		$addMember = new Zend_Session_Namespace('addMember');
		
		$salutation = $form->getValue('salutation');
		$first_name = $form->getValue('first_name');
		$middle_initial = $form->getValue('middle_initial');
		$last_name = $form->getValue('last_name');
		$bio = $form->getValue('member_bio');
		$other_info = $form->getValue('member_other_info');
		
		$photo_uri = $form->getValue('photo_uri');
		if($photo_uri == NULL || $photo_uri == '') {
			$photo_uri = 'blank_avatar.png';
		}

		$deceased = $form->getValue('deceased');
		
		// Store form values in the session
		$addMember->salutation = $salutation;
		$addMember->first_name = $first_name;
		$addMember->middle_initial = $middle_initial;
		$addMember->last_name = $last_name;
		$addMember->bio = $bio;
		$addMember->other_info = $other_info;
		$addMember->photo_uri = $photo_uri;
		$addMember->deceased = $deceased;
		
	}
	
	
	public function storeProfessionalDetails($form) {
		
		Zend_Session::start();
		$addMember = new Zend_Session_Namespace('addMember');
		
		$business_title = $form->getValue('business_title');
		$first_year_eoy_finalist = $form->getValue('first_year_eoy_finalist');
		$other_companies = $form->getValue('member_other_companies');
		$professional_experience = $form->getValue('professional_experience');
		$keywords = $form->getValue('keyword_sel');
		
		// Store form values in the session
		$addMember->business_title = $business_title;
		$addMember->first_year_eoy_finalist = $first_year_eoy_finalist;
		$addMember->other_companies = $other_companies;
		$addMember->professional_experience = $professional_experience;
		$addMember->keywords = $keywords;
		
	}
	
	
	public function storeNomCompanyDetails($form) {
		
		Zend_Session::start();
		$addMember = new Zend_Session_Namespace('addMember');
		
		$company_type = $form->getValue('company_type');
		$addMember->company_type = $company_type;
		
		if($company_type == 'new')
		{
			$nomination_company_name = $form->getValue('nomination_company_name');
			$current_company_name = $form->getValue('current_company_name');
			$company_website = $form->getValue('company_website');
			$num_employees_sel = $form->getValue('num_employees_sel');
			$sector_sel = $form->getValue('sector_sel');
			$previous_company_names = $form->getValue('previous_company_names');
			$other_websites = $form->getValue('other_websites');
			
			$address_1 = $form->getValue('address_1');
			$address_2 = $form->getValue('address_2');
			$address_3 = $form->getValue('address_3');
			$postcode = $form->getValue('postcode');
			$county_sel = $form->getValue('county_sel');
			$country_sel = $form->getValue('country_sel');
			$contact_number = $form->getValue('contact_number');
			
			// Store form values in the session
			$addMember->nomination_company_name = $nomination_company_name;
			$addMember->current_company_name = $current_company_name;
			$addMember->company_website = $company_website;
			$addMember->num_employees_sel = $num_employees_sel;
			$addMember->sector_sel = $sector_sel;
			$addMember->previous_company_names = $previous_company_names;
			$addMember->other_websites = $other_websites;
			$addMember->address_1 = $address_1;
			$addMember->address_2 = $address_2;
			$addMember->address_3 = $address_3;
			$addMember->postcode = $postcode;
			$addMember->county_sel = $county_sel;
			$addMember->country_sel = $country_sel;
			$addMember->contact_number = $contact_number;
		}
		elseif($company_type == 'existing')
		{
			$company_sel = $form->getValue('company_sel');	
			$company_names_view_sel = $form->getValue('company_names_view_sel');
			$arr = explode("-", $company_names_view_sel);
           	$nomination_company_name = $arr[count($arr)-1];
			
			// Store form values in the session
			$addMember->company_sel = $company_sel;
			$addMember->company_names_view_sel = $company_names_view_sel;
			$addMember->nomination_company_name = $nomination_company_name;
		}
		
	}
	
	
	public function storeContactDetails($form) {
		
		Zend_Session::start();
		$addMember = new Zend_Session_Namespace('addMember');
		
		$business_phone = $form->getValue('business_phone');
		$direct_phone = $form->getValue('direct_phone');
		$office_direct_line = $form->getValue('office_direct_line');
		$home_landline = $form->getValue('home_landline');
		$mobile_phone = $form->getValue('mobile_phone');
		$email = $form->getValue('email');
		$email_other = $form->getValue('email_other');
		
		// Store form values in the session
		$addMember->business_phone = $business_phone;
		$addMember->direct_phone = $direct_phone;
		$addMember->office_direct_line = $office_direct_line;
		$addMember->home_landline = $home_landline;
		$addMember->mobile_phone = $mobile_phone;
		$addMember->email = $email;
		$addMember->email_other = $email_other;
		
	}
	
	
	public function storeAltContactDetails($form) {
		
		Zend_Session::start();
		$addMember = new Zend_Session_Namespace('addMember');
		
		$alt_contact_full_name = $form->getValue('alt_contact_full_name');
		$alt_contact_business_title = $form->getValue('alt_contact_business_title');
		$alt_contact_direct_phone = $form->getValue('alt_contact_direct_phone');
		$alt_contact_mobile_phone = $form->getValue('alt_contact_mobile_phone');
		$alt_contact_other_phone = $form->getValue('alt_contact_other_phone');
		$alt_contact_email = $form->getValue('alt_contact_email');
		
		// Store form values in the session
		$addMember->alt_contact_full_name = $alt_contact_full_name;
		$addMember->alt_contact_business_title = $alt_contact_business_title;
		$addMember->alt_contact_direct_phone = $alt_contact_direct_phone;
		$addMember->alt_contact_mobile_phone = $alt_contact_mobile_phone;
		$addMember->alt_contact_other_phone = $alt_contact_other_phone;
		$addMember->alt_contact_email = $alt_contact_email;
		
	}
	
	
	public function storeSocialMediaDetails($form) {
		
		Zend_Session::start();
		$addMember = new Zend_Session_Namespace('addMember');
		
		$social_media_linkedin_name = $form->getValue('social_media_linkedin_name');
		$social_media_facebook_name = $form->getValue('social_media_facebook_name');
		$social_media_skype_id = $form->getValue('social_media_skype_id');
		$social_media_twitter_username = $form->getValue('social_media_twitter_username');
		$social_media_other = $form->getValue('social_media_other');
		
		// Store form values in the session
		$addMember->social_media_linkedin_name = $social_media_linkedin_name;
		$addMember->social_media_facebook_name = $social_media_facebook_name;
		$addMember->social_media_skype_id = $social_media_skype_id;
		$addMember->social_media_twitter_username = $social_media_twitter_username;
		$addMember->social_media_other = $social_media_other;
		
	}
	
	
	public function saveAltContact($form, $m_id) {
			
		if($form == NULL)
		{
			Zend_Session::start();
			$addMember = new Zend_Session_Namespace('addMember');
			
			$alt_contact_full_name = $addMember->alt_contact_full_name;
			$alt_contact_business_title = $addMember->alt_contact_business_title;
			$alt_contact_direct_phone = $addMember->alt_contact_direct_phone;
			$alt_contact_mobile_phone = $addMember->alt_contact_mobile_phone;
			$alt_contact_other_phone = $addMember->alt_contact_other_phone;
			$alt_contact_email = $addMember->alt_contact_email;
		}
		else
		{
			$alt_contact_full_name = $form->getValue('alt_contact_full_name');
			$alt_contact_business_title = $form->getValue('alt_contact_business_title');
			$alt_contact_direct_phone = $form->getValue('alt_contact_direct_phone');
			$alt_contact_mobile_phone = $form->getValue('alt_contact_mobile_phone');
			$alt_contact_other_phone = $form->getValue('alt_contact_other_phone');
			$alt_contact_email = $form->getValue('alt_contact_email');
		}
			
		$alt_contact_tbl = new Application_Model_DbTable_AltContact();
		$member_alt_contact_tbl	= new Application_Model_DbTable_MemberAltContact();		
	
		$data = array(
			'full_name' => $alt_contact_full_name,
			'business_title' => $alt_contact_business_title,
			'direct_phone' => $alt_contact_direct_phone,
			'mobile_phone' => $alt_contact_mobile_phone,
			'other_phone' => $alt_contact_other_phone,
			'email' => $alt_contact_email,
		);
		
		$alt_contact_tbl->addAltContact($data);
		$alt_contact = $alt_contact_tbl->getLastEntered();
		$alt_contact_id = $alt_contact['id'];
		$member_alt_contact_tbl->addMemberAltContact(array('member_profile_id' => $m_id, 'alt_contact_id' => $alt_contact_id));
		
	}
	
	
	public function saveKeywords($keyword_ids, $m_id) {
		
		$member_keyword = new Application_Model_DbTable_MemberKeyword();
		
		foreach($keyword_ids as $keyword_id) {
			$member_keyword->addMemberKeyword(array('member_profile_id' => $m_id, 'keyword_id' => $keyword_id));
		}
		
	}
	
	
	public function saveProfExperience($text, $m_id) {
		
		$data = array(
			'member_profile_id' => $m_id,
			'value' => $text,
		);
		
		$member_prof_exp = new Application_Model_DbTable_MemberProfessionalExperience();
		$member_prof_exp->addMemberProfessionalExperience($data);
		
	}

	public function saveBio($text, $m_id) {
		
		$data = array(
			'member_profile_id' => $m_id,
			'value' => $text,
		);
		
		$member_bio = new Application_Model_DbTable_MemberBio();
		$member_bio->addMemberBio($data);
		
	}
	
	
	public function saveSocialMedia($form, $m_id) {
		
		if($form == NULL)
		{
			Zend_Session::start();
			$addMember = new Zend_Session_Namespace('addMember');
			
			$linkedin_name = $addMember->social_media_linkedin_name;
			$facebook_name = $addMember->social_media_facebook_name;
			$skype_id = $addMember->social_media_skype_id;
			$twitter_username = $addMember->social_media_twitter_username;
			$other = $addMember->social_media_other;
		}
		else
		{
			$linkedin_name = $form->getValue('social_media_linkedin_name');
			$facebook_name = $form->getValue('social_media_facebook_name');
			$skype_id = $form->getValue('social_media_skype_id');
			$twitter_username = $form->getValue('social_media_twitter_username');
			$other = $form->getValue('social_media_other');
		}			    

		$data = array(
			'member_profile_id' => $m_id,
			'linkedin_name' => $linkedin_name,
			'facebook_name' => $facebook_name,
			'skype_id' => $skype_id,
			'twitter_username' => $twitter_username,
			'other' => $other,
		);
		
		$member_social_media = new Application_Model_DbTable_MemberSocialMedia();
		$member_social_media->addMemberSocialMedia($data);
		
	}
	
	
	public function saveOtherCompanies($text, $m_id) {
		
		$companies = explode(",", $text);
		$member_other_companies = new Application_Model_DbTable_MemberOtherCompanies();
		
		foreach($companies as $company) {
			$member_other_companies->addMemberOtherCompany(array('member_profile_id' => $m_id, 'company_name' => $company));
		}
		
	}
	
	
	public function saveOtherInfo($text, $m_id) {
		
		$data = array(
			'member_profile_id' => $m_id,
			'value' => $text,
		);
		
		$member_other_info = new Application_Model_DbTable_MemberOtherInfo();
		$member_other_info->addMemberOtherInfo($data);
		
	}
	
	
	// this function determines whether or not to save alt contact details to member_alt_contact table
	// this function is called when user is editing a member
	public function altContactFields($form) {
		
		$insert; // boolean var
		
		$alt_contact_full_name = $form->getValue('alt_contact_full_name');
		$alt_contact_direct_phone = $form->getValue('alt_contact_direct_phone');
		$alt_contact_mobile_phone = $form->getValue('alt_contact_mobile_phone');
		$alt_contact_other_phone = $form->getValue('alt_contact_other_phone');
		$alt_contact_email = $form->getValue('alt_contact_email');
		
		// full name is required, as well as at least one of the fields below
		if(!(isset($alt_contact_full_name) && $alt_contact_full_name != ''))
		{
			$insert = false;
		}
		else
		{
			if((isset($alt_contact_direct_phone) && $alt_contact_direct_phone != '') ||
				(isset($alt_contact_mobile_phone) && $alt_contact_mobile_phone != '') ||
				(isset($alt_contact_other_phone) && $alt_contact_other_phone != '') ||
				(isset($alt_contact_email) && $alt_contact_email != ''))
				{
					$insert = true;
				}
				else
				{
					$insert = false;
				}
		}
		
		return $insert;
		 
	}


	// this function determines whether or not to save alt contact details to member_alt_contact table
	// this function is called when user is saving a member
	public function altContactVars() {
		
		Zend_Session::start();
		$addMember = new Zend_Session_Namespace('addMember');
		
		$insert; // boolean var
		
		$alt_contact_full_name = $addMember->alt_contact_full_name;
		$alt_contact_direct_phone = $addMember->alt_contact_direct_phone;
		$alt_contact_mobile_phone = $addMember->alt_contact_mobile_phone;
		$alt_contact_other_phone = $addMember->alt_contact_other_phone;
		$alt_contact_email = $addMember->alt_contact_email;
		
		// full name is required, as well as at least one of the fields below
		if(!(isset($alt_contact_full_name) && $alt_contact_full_name != ''))
		{
			$insert = false;
		}
		else
		{
			if((isset($alt_contact_direct_phone) && $alt_contact_direct_phone != '') ||
				(isset($alt_contact_mobile_phone) && $alt_contact_mobile_phone != '') ||
				(isset($alt_contact_other_phone) && $alt_contact_other_phone != '') ||
				(isset($alt_contact_email) && $alt_contact_email != ''))
				{
					$insert = true;
				}
				else
				{
					$insert = false;
				}
		}
		
		return $insert;
		 
	}
	
	// this function determines whether or not to save social media details to social media table
	// this function is called when user is editing a member
	public function socialMediaFields($form) {
		
		$insert; // boolean var
		
		$linkedin_name = $form->getValue('social_media_linkedin_name');
		$facebook_name = $form->getValue('social_media_facebook_name');
		$skype_id = $form->getValue('social_media_skype_id');
		$twitter_username = $form->getValue('social_media_twitter_username');
		$other = $form->getValue('social_media_other');	
		
		if((isset($linkedin_name) && $linkedin_name != '') ||
			(isset($facebook_name) && $facebook_name != '') ||
			(isset($skype_id) && $skype_id != '') ||
			(isset($twitter_username) && $twitter_username != '') ||
			(isset($other) && $other != ''))
			{
				$insert = true;
			}
			else
			{
				$insert = false;
			}
				
		return $insert;
		 
	}
	
	// this function determines whether or not to save social media details to social media table
	// this function is called when user is saving a member
	public function socialMediaVars() {
		
		Zend_Session::start();
		$addMember = new Zend_Session_Namespace('addMember');
		
		$insert; // boolean var
		
		$linkedin_name = $addMember->social_media_linkedin_name;
		$facebook_name = $addMember->social_media_facebook_name;
		$skype_id = $addMember->social_media_skype_id;
		$twitter_username = $addMember->social_media_twitter_username;
		$other = $addMember->social_media_other;	
		
		if((isset($linkedin_name) && $linkedin_name != '') ||
			(isset($facebook_name) && $facebook_name != '') ||
			(isset($skype_id) && $skype_id != '') ||
			(isset($twitter_username) && $twitter_username != '') ||
			(isset($other) && $other != ''))
			{
				$insert = true;
			}
			else
			{
				$insert = false;
			}
				
		return $insert;
		 
	}


	public function updateMemberPersonal($form, $m_id)
	{
		$member_profile	= new Application_Model_DbTable_MemberProfile();
		
		$salutation = $form->getValue('salutation');
		$first_name = $form->getValue('first_name');
		$middle_initial = $form->getValue('middle_initial');
		$last_name = $form->getValue('last_name');  
		$member_bio = $form->getValue('member_bio');
		$this->updateMemberBio($member_bio, $m_id);
		$member_other_info = $form->getValue('member_other_info');
		$this->updateOtherInfo($member_other_info, $m_id);
		
		
		$photo_uri = $form->getValue('photo_uri');
		$member = $member_profile->getMemberProfile($m_id);
		$curr_photo = $member['photo_uri'];
		
		if($photo_uri == NULL || $photo_uri == '') {
			if($curr_photo != 'images/profile_pics/blank_avatar.png') {
				$photo_uri = substr(strrchr($curr_photo, '/'), 1); // get everything after last forward slash
			} else {
				$photo_uri = 'blank_avatar.png';
			}
		} else { // $photo_uri already set in form. don't need to do anything
			 
		}
		
		$deceased = $form->getValue('deceased');
		
		$data = array(
			'salutation' => $salutation,
			'first_name' => $first_name,
			'middle_initial' => $middle_initial,
			'last_name' => $last_name,  
			'photo_uri' => "images/profile_pics/" .  $photo_uri,
			'deceased' => $deceased,
		);
		
		$member_profile->updateMemberProfile($data, $m_id);

	}
	
	
	public function updateMemberProfessional($form, $m_id)
	{
		$member_profile	= new Application_Model_DbTable_MemberProfile();
		
		$business_title = $form->getValue('business_title');
		$first_year_eoy_finalist = $form->getValue('first_year_eoy_finalist');
		$other_companies = $form->getValue('member_other_companies');
		$this->updateOtherCompanies($other_companies, $m_id);
		$prof_experience = $form->getValue('professional_experience');
		$this->updateProfExperience($prof_experience, $m_id);
		$keyword_ids = $form->getValue('keyword_sel');
		$this->updateKeywords($keyword_ids, $m_id);
		
		
		/* currently not allowing edit of nomination company name in form, only through DB
		$company_names_view_sel = $form->getValue('company_names_sel');
		$arr = explode("-", $company_names_view_sel);
        $nomination_company_name = $arr[count($arr)-1];
		*/
		
		$data = array(
			'business_title' => $business_title,
			'first_year_eoy_finalist' => $first_year_eoy_finalist,
			//'nomination_company_name' => $nomination_company_name,  
		);
		
		$member_profile->updateMemberProfile($data, $m_id);

	}
	
	
	public function updateMemberContact($form, $m_id)
	{
		$member_profile	= new Application_Model_DbTable_MemberProfile();
		
		$direct_phone = $form->getValue('direct_phone');
		$business_phone = $form->getValue('business_phone');
		$office_direct_line = $form->getValue('office_direct_line');
		$home_landline = $form->getValue('home_landline');
		$mobile_phone = $form->getValue('mobile_phone');
		$email = $form->getValue('email');
		$email_other = $form->getValue('email_other');
		
		$data = array(
			'direct_phone' => $direct_phone,
			'business_phone' => $business_phone,
			'office_direct_line' => $office_direct_line,
			'home_landline' => $home_landline,
			'mobile_phone' => $mobile_phone,
			'email' => $email,
			'email_other' => $email_other,
		);
		
		$member_profile->updateMemberProfile($data, $m_id);

	}
	
	
	public function updateAltContact($form, $m_id) {
		
		// check if there's an entry in alt contacts table for this member.
		// if so, just update it, if not, add a new entry to table
		$alt_contact_tbl = new Application_Model_DbTable_AltContact();
		$member_alt_contact_tbl	= new Application_Model_DbTable_MemberAltContact();
		$member_alt_contact = $member_alt_contact_tbl->getMemberAltContact($m_id);
		
		if($member_alt_contact != NULL) { //update alt contact in alt_contact table
			
			$alt_contact_full_name = $form->getValue('alt_contact_full_name');
			$alt_contact_business_title = $form->getValue('alt_contact_business_title');
			$alt_contact_direct_phone = $form->getValue('alt_contact_direct_phone');
			$alt_contact_mobile_phone = $form->getValue('alt_contact_mobile_phone');
			$alt_contact_other_phone = $form->getValue('alt_contact_other_phone');
			$alt_contact_email = $form->getValue('alt_contact_email');
	
			$data = array(
				'full_name' => $alt_contact_full_name,
				'business_title' => $alt_contact_business_title,
				'direct_phone' => $alt_contact_direct_phone,
				'mobile_phone' => $alt_contact_mobile_phone,
				'other_phone' => $alt_contact_other_phone,
				'email' => $alt_contact_email,
			);
			
			$alt_contact_tbl->updateAltContact($data, $member_alt_contact['alt_contact_id']);
			
		} else { // insert new record
			
			$this->saveAltContact($form, $m_id);
			
		}
		
	}


	public function updateKeywords($keyword_ids, $m_id) {

		$member_keyword = new Application_Model_DbTable_MemberKeyword();
		$keywords = $member_keyword->getMemberKeywords($m_id);
		
		if($keywords != NULL) { //this member has at least one entry in keyword table
			if(isset($keyword_ids)) {
				// compare existing keyword id's for this member against currently selected keyword id's in form
				// if different, delete old records and add new ones				
				$existing_keyword_ids = '';
				foreach($keywords as $keyword) {
					$existing_keyword_ids .= $keyword['keyword_id'];
				}
				
				if(implode($keyword_ids) != $existing_keyword_ids) { //updates made to member keywords.
					$member_keyword->deleteMemberKeywords($m_id);
					$this->saveKeywords($keyword_ids, $m_id);
				}
				
			} else { //delete all records from member_keyword table with this member's id
				$member_keyword->deleteMemberKeywords($m_id);
			}
		} else { // no entry in table
			if(isset($keyword_ids)) {
				$this->saveKeywords($keyword_ids, $m_id);
			}
		}
	}
	
	
	public function updateProfExperience($text, $m_id) {
		
		$member_prof_exp = new Application_Model_DbTable_MemberProfessionalExperience();
		$prof_exp = $member_prof_exp->getMemberProfessionalExperience($m_id);
		
		if($prof_exp != NULL) {
			//do a string comparison between what's in table and what's in form
			if($text == $prof_exp['value']) {
				// don't do anything. text hasn't been changed
			} else {
				if(isset($text) && $text != '') {
					// update record
					$data = array(
						'member_profile_id' => $m_id,
						'value' => $text,
					);
					$member_prof_exp->updateMemberProfessionalExperience($data, $m_id);
				} else {
					// form field is empty. delete record
					$member_prof_exp->deleteMemberProfessionalExperience($m_id);
				}				
			}
		} else { // no previous prof experience saved for this member, so save record
			if(isset($text) && $text != '') {
				$this->saveProfExperience($text, $m_id);
			}
					
		}
		
	}
	
	
	public function updateMemberBio($text, $m_id) {
		
		$member_bio = new Application_Model_DbTable_MemberBio();
		$bio = $member_bio->getMemberBio($m_id);
		
		if($bio != NULL) {
			//do a string comparison between what's in table and what's in form
			if($text == $bio['value']) {
				// don't do anything. text hasn't been changed
			} else {
				if(isset($text) && $text != '') {
					// update record
					$data = array(
						'member_profile_id' => $m_id,
						'value' => $text,
					);
					$member_bio->updateMemberBio($data, $m_id);
				} else {
					// form field is empty. delete record
					$member_bio->deleteMemberBio($m_id);
				}				
			}
		} else { // no previous prof experience saved for this member, so save record
			if(isset($text) && $text != '') {
				$this->saveBio($text, $m_id);
			}
					
		}
		
	}
	
	
	public function updateSocialMedia($form, $m_id) {
		
		$linkedin_name = $form->getValue('social_media_linkedin_name');
		$facebook_name = $form->getValue('social_media_facebook_name');
		$skype_id = $form->getValue('social_media_skype_id');
		$twitter_username = $form->getValue('social_media_twitter_username');
		$other = $form->getValue('social_media_other');	    

		$data = array(
			'member_profile_id' => $m_id,
			'linkedin_name' => $linkedin_name,
			'facebook_name' => $facebook_name,
			'skype_id' => $skype_id,
			'twitter_username' => $twitter_username,
			'other' => $other,
		);
		
		$member_social_media = new Application_Model_DbTable_MemberSocialMedia();
		$social_media = $member_social_media->getMemberSocialMedia($m_id);
		
		if($social_media != NULL) {
			// already an entry in social media table, so update with new info
			$member_social_media->updateMemberSocialMedia($data, $m_id);
		} else {
			// save new record in table
			$this->saveSocialMedia($form, $m_id);
		}		
		
	}
	
	
	public function updateOtherCompanies($text, $m_id) {
		// this function is not ideal currently. it is almost like a patch
		// the way in which member other companies are updated could be improved upon
		// so that each 'other company' could be passed here individually, rather that all member
		// other companies being passed to this function in a comma delimited string
		// that way, each 'other company' would retain it's id
		$member_other_companies = new Application_Model_DbTable_MemberOtherCompanies();
		$other_companies = $member_other_companies->getMemberOtherCompanies($m_id);
		
		$str = '';
		if($other_companies != NULL) { //this member has at least one entry in memberOtherCompanies table
			if(isset($text) && $text != '') {
				//compare memberOtherCompanies in table with what's currently in the form
				foreach ($other_companies as $other_company) {
					$str .= $other_company['company_name'] . ',';
				}
				$str = substr($str, 0, strlen($str)-1); // chop off last comma
			
				if($text != $str) { // changes have been made in the form to the otherCompanies
					$member_other_companies->deleteMemberOtherCompanies($m_id); // delete record/s from table
					$this->saveOtherCompanies($text, $m_id); // add record/s to table
				} 
			} else { // no text in form for other Companies
				$member_other_companies->deleteMemberOtherCompanies($m_id); // delete record/s from table
			}
			
		} else { // no entry in table
			if(isset($text) && $text != '') {
				$this->saveOtherCompanies($text, $m_id); // add record/s to table
			}
		}
		
	}
	
	
	public function updateOtherInfo($text, $m_id) {
		
		$member_other_info = new Application_Model_DbTable_MemberOtherInfo();
		$other_info = $member_other_info->getMemberOtherInfo($m_id);
		
		if($other_info != NULL) {
			//do a string comparison between what's in table and what's in form
			if($text == $other_info['value']) {
				// don't do anything. text hasn't been changed
			} else {
				if(isset($text) && $text != '') {
					// update record
					$data = array(
						'member_profile_id' => $m_id,
						'value' => $text,
					);
					$member_other_info->updateMemberOtherInfo($data, $m_id);
				} else {
					// form field is empty. delete record
					$member_other_info->deleteMemberOtherInfo($m_id);
				}				
			}
		} else { // no previous prof experience saved for this member, so save record
			if(isset($text) && $text != '') {
				$this->saveOtherInfo($text, $m_id);
			}
					
		}
		
	}
	
	
	public function updateWildCardField($field, $value, $m_id) {
		
		$member_tbl = new Application_Model_DbTable_MemberProfile();
		
		$data = array(
			$field => $value,
		);
		
		$member_tbl->updateMemberProfile($data, $m_id);
		
	}

	// function used to display values already entered by user in form fields
	// values have been saved in session vars
	// this is during the process of adding a new member
	public function populateFormAddMemPersonal($form) {
		
		Zend_Session::start();
		$addMember = new Zend_Session_Namespace('addMember');
		
		if(isset($addMember->salutation)) {
			$form->salutation->setValue($addMember->salutation);
		}
		if(isset($addMember->first_name)) {
			$form->first_name->setValue($addMember->first_name);
		}
		if(isset($addMember->middle_initial)) {
			$form->middle_initial->setValue($addMember->middle_initial);
		}
		if(isset($addMember->last_name)) {
			$form->last_name->setValue($addMember->last_name);
		}
		if(isset($addMember->bio)) {
			$form->member_bio->setValue($addMember->bio);
		}
		if(isset($addMember->other_info)) {
			$form->member_other_info->setValue($addMember->other_info);
		}
		if(isset($addMember->photo_uri)) {
			$form->photo_uri->setValue($addMember->photo_uri);
		}
		if(isset($addMember->deceased)) {
			$form->deceased->setValue($addMember->deceased);
		}
		
	}
	
	// called during the process of editing a member
	public function populateFormMemPersonal($form, $m_id) {
		
		$member_tbl = new Application_Model_DbTable_MemberProfile();
		$bio_tbl = new Application_Model_DbTable_MemberBio();
		$other_info_tbl = new Application_Model_DbTable_MemberOtherInfo();
		
		$member = $member_tbl->getMemberProfile($m_id);
		$bio = $bio_tbl->getMemberBio($m_id);
		$other_info = $other_info_tbl->getMemberOtherInfo($m_id);
		
		// start of member profile details
		$form->salutation->setValue($member['salutation']);
    	$form->first_name->setValue($member['first_name']);
		$form->middle_initial->setValue($member['middle_initial']);
		$form->last_name->setValue($member['last_name']);
		$form->deceased->setValue($member['deceased']);
		// end of member profile details
		
		// start of Bio
		if($bio != NULL) {
			$form->member_bio->setValue($bio['value']);
		}
		// end of Bio
		
		// start of other info
		if($other_info != NULL) {
			$form->member_other_info->setValue($other_info['value']);
		}
		// end of other info
	}
	
	// function used to display values already entered by user in form fields
	// values have been saved in session vars
	// this is during the process of adding a new member
	public function populateFormAddMemProfessional($form) {
		
		Zend_Session::start();
		$addMember = new Zend_Session_Namespace('addMember');
		
		if(isset($addMember->business_title)) {
			$form->business_title->setValue($addMember->business_title);
		}
		if(isset($addMember->first_year_eoy_finalist)) {
			$form->first_year_eoy_finalist->setValue($addMember->first_year_eoy_finalist);
		}
		if(isset($addMember->other_companies)) {
			$form->member_other_companies->setValue($addMember->other_companies);
		}
		if(isset($addMember->professional_experience)) {
			$form->professional_experience->setValue($addMember->professional_experience);
		}
		if(isset($addMember->keywords)) {
			$form->keyword_sel->setValue($addMember->keywords);
		}
		
	}
	
	// function used to display values already entered by user in form fields
	// values have been saved in session vars
	// this is during the process of adding a new member
	public function populateFormAddMemNomCompany($form) {
		
		Zend_Session::start();
		$addMember = new Zend_Session_Namespace('addMember');
		/*
		if(isset($addMember->company_type)) {
			$form->company_type->setValue($addMember->company_type);
		}
		*/
		if(isset($addMember->nomination_company_name)) {
			$form->nomination_company_name->setValue($addMember->nomination_company_name);
		}
		if(isset($addMember->current_company_name)) {
			$form->current_company_name->setValue($addMember->current_company_name);
		}
		if(isset($addMember->company_website)) {
			$form->company_website->setValue($addMember->company_website);
		}
		if(isset($addMember->num_employees_sel)) {
			$form->num_employees_sel->setValue($addMember->num_employees_sel);
		}
		if(isset($addMember->sector_sel)) {
			$form->sector_sel->setValue($addMember->sector_sel);
		}
		if(isset($addMember->previous_company_names)) {
			$form->previous_company_names->setValue($addMember->previous_company_names);
		}
		if(isset($addMember->other_websites)) {
			$form->other_websites->setValue($addMember->other_websites);
		}
		if(isset($addMember->address_1)) {
			$form->address_1->setValue($addMember->address_1);
		}
		if(isset($addMember->address_2)) {
			$form->address_2->setValue($addMember->address_2);
		}
		if(isset($addMember->address_3)) {
			$form->address_3->setValue($addMember->address_3);
		}
		if(isset($addMember->postcode)) {
			$form->postcode->setValue($addMember->postcode);
		}
		if(isset($addMember->county_sel)) {
			$form->county_sel->setValue($addMember->county_sel);
		}
		if(isset($addMember->country_sel)) {
			$form->country_sel->setValue($addMember->country_sel);
		}
		if(isset($addMember->contact_number)) {
			$form->contact_number->setValue($addMember->contact_number);
		}
		if(isset($addMember->company_sel)) {
			$form->company_sel->setValue($addMember->company_sel);
		}
		if(isset($addMember->company_names_view_sel)) {
			$form->company_names_view_sel->setValue($addMember->company_names_view_sel);
		}
		
	}
	
	// called during the process of editing a member
	public function populateFormMemProfessional($form, $m_id) {
		
		$member_tbl = new Application_Model_DbTable_MemberProfile();
		$keywords_tbl = new Application_Model_DbTable_MemberKeyword();
		$prof_experience_tbl = new Application_Model_DbTable_MemberProfessionalExperience();
		$other_companies_tbl = new Application_Model_DbTable_MemberOtherCompanies();
		
		$member = $member_tbl->getMemberProfile($m_id);
		$keywords = $keywords_tbl->getMemberKeywords($m_id);
		$prof_experience = $prof_experience_tbl->getMemberProfessionalExperience($m_id);
		$other_companies = $other_companies_tbl->getMemberOtherCompanies($m_id);
		
		// start of member profile details
		$form->business_title->setValue($member['business_title']);
		$form->first_year_eoy_finalist->setValue($member['first_year_eoy_finalist']);
		// end of member profile details
		
		// start of member keywords details
		if($keywords != NULL) {
			$keyword_ids = array();
			
			foreach ($keywords as $keyword) {
				$keyword_ids[] = $keyword['keyword_id'];
			}
			
			$form->keyword_sel->setValue($keyword_ids);
		}
		// end of member keyword details
		
		// start of professional experience
		if($prof_experience != NULL) {
			$form->professional_experience->setValue($prof_experience['value']);
		}
		// end of professional experience
		
		// start of other companies
		if($other_companies != NULL) {

			$str = '';
			
			foreach ($other_companies as $other_company) {
				$str .= $other_company['company_name'] . ',';
			}
			// chop off last comma
			$str = substr($str, 0, strlen($str)-1); 
			$form->member_other_companies->setValue($str);
		}
		// end of other companies		
	}

	// function used to display values already entered by user in form fields
	// values have been saved in session vars
	// this is during the process of adding a new member
	public function populateFormAddMemContact($form) {
		
		Zend_Session::start();
		$addMember = new Zend_Session_Namespace('addMember');
		
		if(isset($addMember->business_phone)) {
			$form->business_phone->setValue($addMember->business_phone);
		}
		if(isset($addMember->direct_phone)) {
			$form->direct_phone->setValue($addMember->direct_phone);
		}
		if(isset($addMember->office_direct_line)) {
			$form->office_direct_line->setValue($addMember->office_direct_line);
		}
		if(isset($addMember->home_landline)) {
			$form->home_landline->setValue($addMember->home_landline);
		}
		if(isset($addMember->mobile_phone)) {
			$form->mobile_phone->setValue($addMember->mobile_phone);
		}
		if(isset($addMember->email)) {
			$form->email->setValue($addMember->email);
		}
		if(isset($addMember->email_other)) {
			$form->email_other->setValue($addMember->email_other);
		}
		
	}
	
	// called during the process of editing a member
	public function populateFormMemContactInfo($form, $m_id) {
		
		$member_tbl = new Application_Model_DbTable_MemberProfile();
		$member = $member_tbl->getMemberProfile($m_id);
		
		$form->direct_phone->setValue($member['direct_phone']);
		$form->business_phone->setValue($member['business_phone']);
		$form->office_direct_line->setValue($member['office_direct_line']);
		$form->home_landline->setValue($member['home_landline']);
		$form->mobile_phone->setValue($member['mobile_phone']);
		$form->email->setValue($member['email']);
		$form->email_other->setValue($member['email_other']);
		
	}
	
	// function used to display values already entered by user in form fields
	// values have been saved in session vars
	// this is during the process of adding a new member
	public function populateFormAddMemAltContact($form) {
		
		Zend_Session::start();
		$addMember = new Zend_Session_Namespace('addMember');
		
		if(isset($addMember->alt_contact_full_name)) {
			$form->alt_contact_full_name->setValue($addMember->alt_contact_full_name);
		}
		if(isset($addMember->alt_contact_business_title)) {
			$form->alt_contact_business_title->setValue($addMember->alt_contact_business_title);
		}
		if(isset($addMember->alt_contact_direct_phone)) {
			$form->alt_contact_direct_phone->setValue($addMember->alt_contact_direct_phone);
		}
		if(isset($addMember->alt_contact_mobile_phone)) {
			$form->alt_contact_mobile_phone->setValue($addMember->alt_contact_mobile_phone);
		}
		if(isset($addMember->alt_contact_other_phone)) {
			$form->alt_contact_other_phone->setValue($addMember->alt_contact_other_phone);
		}
		if(isset($addMember->alt_contact_email)) {
			$form->alt_contact_email->setValue($addMember->alt_contact_email);
		}
		
	}
	
	// called during the process of editing a member
	public function populateFormMemAltContactDetails($form, $m_id) {
		
		$member_tbl = new Application_Model_DbTable_MemberProfile();
		$member = $member_tbl->getMemberProfile($m_id);
		
		$alt_contact_tbl = new Application_Model_DbTable_AltContact();
		$member_alt_contact_tbl = new Application_Model_DbTable_MemberAltContact();
		$member_alt_contact = $member_alt_contact_tbl->getMemberAltContact($m_id);
		$alt_contact = $alt_contact_tbl->getAltContact($member_alt_contact['alt_contact_id']);
		
		// start of alt contact details
		if($alt_contact != NULL) {	
			$form->alt_contact_full_name->setValue($alt_contact['full_name']);
			$form->alt_contact_business_title->setValue($alt_contact['business_title']);
			$form->alt_contact_direct_phone->setValue($alt_contact['direct_phone']);
			$form->alt_contact_mobile_phone->setValue($alt_contact['mobile_phone']);
			$form->alt_contact_other_phone->setValue($alt_contact['other_phone']);
			$form->alt_contact_email->setValue($alt_contact['email']);
		}
		// end of alt contact details		
	}
	
	// function used to display values already entered by user in form fields
	// values have been saved in session vars
	// this is during the process of adding a new member
	public function populateFormAddMemSocMedia($form) {
		
		Zend_Session::start();
		$addMember = new Zend_Session_Namespace('addMember');
		
		if(isset($addMember->social_media_linkedin_name)) {
			$form->social_media_linkedin_name->setValue($addMember->social_media_linkedin_name);
		}
		if(isset($addMember->social_media_facebook_name)) {
			$form->social_media_facebook_name->setValue($addMember->social_media_facebook_name);
		}
		if(isset($addMember->social_media_skype_id)) {
			$form->social_media_skype_id->setValue($addMember->social_media_skype_id);
		}
		if(isset($addMember->social_media_twitter_username)) {
			$form->social_media_twitter_username->setValue($addMember->social_media_twitter_username);
		}
		if(isset($addMember->social_media_other)) {
			$form->social_media_other->setValue($addMember->social_media_other);
		}
		
	}
	
	// called during the process of editing a member
	public function populateFormMemSocMedia($form, $m_id) {
		
		$member_tbl = new Application_Model_DbTable_MemberProfile();
		$member = $member_tbl->getMemberProfile($m_id);
		
		$social_media_tbl = new Application_Model_DbTable_MemberSocialMedia();
		$soc_media = $social_media_tbl->getMemberSocialMedia($m_id);
		
		// start of social media
		if($soc_media != NULL) {
			$form->social_media_linkedin_name->setValue($soc_media['linkedin_name']);
			$form->social_media_facebook_name->setValue($soc_media['facebook_name']);
			$form->social_media_skype_id->setValue($soc_media['skype_id']);
			$form->social_media_twitter_username->setValue($soc_media['twitter_username']);
			$form->social_media_other->setValue($soc_media['other']);
		}
		// end of social media
	}

	
}
