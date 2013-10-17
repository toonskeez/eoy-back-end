<?php

class Application_Model_DbTable_CompanyDetailsView extends Zend_Db_Table_Abstract
{

    protected $_name = 'company_details_view';
	// Need to set primary key as this is a view, not a table
	// if we don't set this, we'll get an error saying that table has no primary key
	
	protected $_primary  = 'id';
   	protected $_sequence = false;


}

