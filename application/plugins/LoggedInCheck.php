<?php

	Class Plugin_LoggedInCheck extends Zend_Controller_Plugin_Abstract {

		private $_auth = null;

		public function __construct(Zend_Auth $auth) {
			$this->_auth = $auth;
		}

		public function preDispatch(Zend_Controller_Request_Abstract $request) {
			$resource = $request->getControllerName();
			$action = $request->getActionName();

			$identity = $this->_auth->getStorage()->read();
			$role = $identity->role;

			if($role == NULL || $role != 'admin')
			{
				$request->setControllerName('auth')
						->setActionName('index');
			}
			/*
			else
			{
				if($role == 'admin') {
					$request->setControllerName($resource)
						->setActionName($action);
				}
			}
			*/
		}

	}
