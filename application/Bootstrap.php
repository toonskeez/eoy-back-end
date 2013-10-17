<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initAutoload() {

			$modelLoader = new Zend_Application_Module_Autoloader(array(
							'namespace' => '',
							'basePath' => APPLICATION_PATH));

			$auth = Zend_Auth::getInstance();

			$fc = Zend_Controller_Front::getInstance();
			$fc->registerPlugin(new Plugin_LoggedInCheck($auth));

			return $modelLoader;

	}

}

