<?php

namespace Canti\Controllers;

use Canti\Models\User;

class UserController
{
	private
	private $_model;
	private $_updateFlag;
	
	public function __construct($userArray = null)
	{
		if($userArray != null)
		{
			$this->_model = new User();
			$this->_model->$UserID = $userArray["UserID"];
			$this->_model->$Username = $userArray["Username"];
			$this->_model->$PasswordHash = $userArray["PasswordHash"];
			$this->_model->$Email = $userArray["Email"];
			$this->_model->$CreatedOn = $userArray["CreatedOn"];
			$this->_model->$RegisteredIP = $userArray["RegisteredIP"];
			$this->_model->$LastLogin = $userArray["LastLogin"];
			$this->_model->$IsAdmin = $userArray["IsAdmin"];
		}
		else
		{
			$this->_model = new User();
		}
		$this->_updateFlag = false;
	}
	
	// get
	
	// set
}