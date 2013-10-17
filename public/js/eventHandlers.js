//function to pre-load page content for main pages and bind functions to button clicks

function setupPages(){
	
	$(document).ready(function() { // start of document ready function
    	
    	/******************************* Start of Add Member form functions ******************************************/
    	$('fieldset.new-company :input').attr('disabled', true);
    	$('fieldset.existing-company :input').attr('disabled', true);
    	
        $('input[name=company_type]:radio').bind($.browser.msie? 'click': 'change', function () { // bind even handler to company type radio group
			
			$('fieldset.new-company :input').attr('disabled', false);
   			$('fieldset.existing-company :input').attr('disabled', false);
			
			var companyType = $('input[name=company_type]:checked').val();

			if(companyType == 'new') { // hide non-relevant form fields. show relevant ones
				$('fieldset.new-company').show();
				$('fieldset.existing-company').hide();
			} else if(companyType == 'existing') { // hide non-relevant form fields. show relevant ones
				$('fieldset.new-company').hide();
				$('fieldset.existing-company').show();
			}
		}); // End of binding to company type radio group
		
		// if user selects a nomination company name that is not a previous name
		// of the currently selected company, alert the user
		$("#company_names_view_sel").change(function() {
			var nomCompanyID = $("#company_names_view_sel").val();
			var companyID = $("#company_sel").val();
			var companyName = $("#company_sel option:selected").text();
			nomCompanyID = nomCompanyID.split("-");
			nomCompanyID = nomCompanyID[0];
			if(nomCompanyID != companyID) {
				alert("That nomination name is not a previous company name" + "\n" +
						"of the currently selected company: " +  "\"" + companyName + "\"");
			}
		});
		
		// if user selects a company and the currently selected nomination
		// company name is not a previous company name of the company selected,
		// alert the user
		$("#company_sel").change(function() {
			var companyID = $("#company_sel").val();
			var nomCompanyID = $("#company_names_view_sel").val();
			nomCompanyID = nomCompanyID.split("-");
			nomCompanyID = nomCompanyID[0];
			var companyName = $("#company_sel option:selected").text();
			var nomCompanyName = $("#company_names_view_sel option:selected").text();
			if(nomCompanyID != companyID) {
				alert("Company: " + "\"" + companyName + "\"" + " is not associated with the" + "\n" +
						"Nomination company name currently selected : " +  "\"" + nomCompanyName + "\"");
			}
		});
		
		
		$('#submit_btn_add_member_nom_comp').bind('click', function() {
			
			var companyType = $('input[name=company_type]:checked').val();
			
			if(companyType == 'existing')
			{
				var companyID = $('#company_sel').val();
				var nomCompanyID = $('#company_names_view_sel').val();
				nomCompanyID = nomCompanyID.split("-");
				nomCompanyID = nomCompanyID[0];
				
				if(nomCompanyID != companyID) { //different company id's. alert user
					alert("Selected company and selected nomination company name\n" +
							"Refer to different companies.\n" +
							"Both selections must refer to the same company.");
					return false; 
				} else {
					return true;
				}
			}
			else if(companyType == 'new')
			{
				var nomName = $('#nomination_company_name').val();
				var curName = $('#current_company_name').val();
				var website = $('#company_website').val();
				var address1 = $('#address_1').val();
				var county = $('#county_sel').val();
				var country = $('#country_sel').val();
				
				var numEployees = $('#num_employees_sel').val();
				var sector = $('#sector_sel').val();
				
				var required = [nomName, curName, website, address1, county, country];
				var required_sels = [numEployees, sector, country]; // none of these can have a value of 0
				
				var min = true; // var to set whether minimum fields have been filled
				
				$.each(required, function(index, value) {
					if(value == null || value == '') {
						min = false;
						return false;
					}
				});
				
				if(min == false) {
					alert("Please fill in all required fields\n" +
							"Required fields are marked with a *");
					return false;
				} else {
					// check that num employees, sector and country are not = 0
					$.each(required_sels, function(index, value) {
						if(value == '0') { // user has selected first item in list
							min = false;
							return false;
						}
					});
					
					if(min == false) {
						alert("Please fill in all required fields\n" +
						"Required fields are marked with a *");
						return false;
					}
					
					// compare values in both county and country.
					// if county is 0, country can't be ireland
					if(county == 0 && country == 103) { // (ireland id is 103)
						alert("If you select Ireland for country, you must select a county");
						return false;
					}
					
					if(county != 0 && country != 103) {
						alert("If you don\'t select Ireland for country, you have to select the\n"
						+ "first item (\"choose county\") in the \'County\' drop down list");
						return false;
					}
					
					// store details
					return true;
				}
			}
		}); // end of function
		
		
		$('#submit_btn_add_company').bind('click', function() {
			
			var numEployees = $('#num_employees_sel').val();
			var sector = $('#sector_sel').val();
			var county = $('#county_sel').val();
			var country = $('#country_sel').val();
			
			var required_sels = [numEployees, sector, country]; // none of these can have a value of 0
				
			var min = true; // var to set whether minimum fields have been filled
			
			$.each(required_sels, function(index, value) {
						if(value == '0') { // user has selected first item in list
							min = false;
							return false;
						}
					});
					
					if(min == false) {
						alert("Please fill in all required fields\n" +
						"Required fields are marked with a *");
						return false;
					}
					
					// compare values in both county and country.
					// if county is 0, country can't be ireland
					if(county == 0 && country == 103) { // (ireland id is 103)
						alert("If you select Ireland for country, you must select a county");
						return false;
					}
					
					if(county != 0 && country != 103) {
						alert("If you don\'t select Ireland for country, you have to select the\n"
						+ "first item (\"choose county\") in the \'County\' drop down list");
						return false;
					}
					
					// store details
					return true;
				
		}); // end of function
		
		
		$('#country_sel').bind('change', function() {
			
			var country = $('#country_sel').val();
						
			if(country != 103) {
				$('#county_sel').val("0");
			}
			
		}); // end of function
		
		
		$('#county_sel').bind('change', function() {
			
			var county = $('#county_sel').val();
						
			if(county != 0) {
				$('#country_sel').val("103");
			}
			
		}); // end of function
		
		
		$('#submit_btn_edit_comp_office').bind('click', function() {
			
			var county = $('#county_sel').val();
			var country = $('#country_sel').val();
			
			if(country == 0) {
				alert('You must select a country');
				return false;
			}
			
			// compare values in both county and country.
			// if county is 0, country can't be ireland
			if(county == 0 && country == 103) { // (ireland id is 103)
				alert("If you select Ireland for country, you must select a county");
				return false;
			}
				
			if(county != 0 && country != 103) {
				alert("If you don\'t select Ireland for country, you have to select the\n"
				+ "first item (\"choose county\") in the \'County\' drop down list");
				return false;
			}
					
			// store details
			return true;
			
		}); // end of function
		
		
		$('#add_member_submit_btn').bind('click', function() {
			// If member is being associated with an existing company
			// check that id of nomination company name is same as id of company
			// if so, proceed with submit of form, else alert user and halt submit of form
			var companyType = $('input[name=company_type]:checked').val();
			
			if(companyType == 'existing') {
				var companyID = $('#company_sel').val();
				var nomCompanyID = $('#company_names_view_sel').val();
				nomCompanyID = nomCompanyID.split("-");
				nomCompanyID = nomCompanyID[0];
				if(nomCompanyID != companyID) {
					return false; 
				} else {
					return true;
				}
			}
		}); // end of function
		
		
		$('#submit_btn_mem_altcontact').bind('click', function() {
			// alert user if not enough fields are filled in, otherwise, submit data
			var direct_phone = $("#alt_contact_direct_phone").val();
			var mob_phone = $("#alt_contact_mobile_phone").val();
			var other_phone = $("#alt_contact_other_phone").val();
			var email = $("#alt_contact_email").val();
			
			var arr = [direct_phone, mob_phone, other_phone, email];
			var min = false; // var to set whether minimum fields have been filled
			
			$.each(arr, function(index, value) {
				if(value != '') {
					min = true;
					return false;
				}
			});
			
			if(!min) {
				alert('You have to enter full name, at least one\nPhone number and / or an email address');
				return false;
			}
		}); // end of function
		
		
		$('#submit_btn_mem_socialmedia').bind('click', function() {
			// alert user if not enough fields are filled in, otherwise, submit data
			var linkedin = $("#social_media_linkedin_name").val();
			var facebook = $("#social_media_facebook_name").val();
			var skype = $("#social_media_skype_id").val();
			var twitter = $("#social_media_twitter_username").val();
			var other = $("#social_media_other").val();
			
			var arr = [linkedin, facebook, skype, twitter, other];
			var min = false; // var to set whether minimum fields have been filled
			
			$.each(arr, function(index, value) {
				if(value != '') {
					min = true;
					return false;
				}
			});
			
			if(!min) {
				alert('If you want to save social media details,\nYou have to fill in at least one text box,\nOtherwise click \'Cancel\'');
				return false;
			}
		}); // end of function
		
		
		$('#cancel_btn_add_member_main').bind('click', function() {
			// go to member page
			$(location).attr("href", 'member');
		}); // end of function
		
		
		$('#cancel_btn_add_member').bind('click', function() {
			// go to addmember page
			$(location).attr("href", 'addmember');
		}); // end of function
	
		
		$('#cancel_btn_edit_member').bind('click', function () {
			var url = $(location).attr('href'); // get current url
			history.back(); // go to previous page
			prevUrl = $(location).attr('href');
			if(url == prevUrl) { //this will be the case if zend validation adds a validation message to the page
				//get query part of url
				var urlParts = url.split('?');
				var query = urlParts[1];
				$(location).attr("href", 'editmember' + '?' + query);
			}
			return false;
		});
		
		
		$('#cancel_btn_add_company').bind('click', function() {
			// go to member page
			$(location).attr("href", 'company');
		}); // end of function
		
		
		$('#cancel_btn_edit_company').bind('click', function () {
			history.back(); // go to previous page
			return false;
		});
		
		
		$('#cancel_btn_search_member').bind('click', function() {
			// go to member page
			$(location).attr("href", '/admin/member');
		}); // end of function
		
		/******************************* End of Add Member form functions ******************************************/
        
    }); // end of document ready function
	

}//end of setupPages()