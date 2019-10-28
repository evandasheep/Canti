<?php

class User extends DataObject
{
	protected $userId;
	protected $userName;
	protected $userPassword;
	protected $userEmail;
	protected $userIsLoggedIn;
	protected $userIsAdmin;
	protected $userTitle;
	
	public function __construct()
	{
		$this->userEmail = 'canti@example.com';
		$this->userIsAdmin = false;
	}
	
	public function constructObject($id, $username, $password, $email, $isAdmin, $title)
	{
		$this->userId = $id;
		$this->userName = $username;
		$this->userPassword = $password;
		$this->userEmail = $email;
		$this->userIsAdmin = $isAdmin;
		$this->userTitle = $title;
	}
	
	// GET
	public function get_userSession()
	{
		if (isset($_SESSION['userId']) && isset($_SESSION['sessToken']))
		{
			$this->userId = $_SESSION['userId'];			
			$_SESSION['lastActivity'] = $_SERVER['REQUEST_TIME'];
			return array($_SESSION['userId'], $_SESSION['sessToken']);
		}
		else
		{
			return false;
		}
	}
	
	public function get_userId()
	{
		return $this->userId;
	}
	
	public function get_userName()
	{
		return $this->userName;
	}
	
	public function get_userPassword()
	{
		return $this->userPassword;
	}
	
	public function get_userEmail()
	{
		return $this->userEmail;
	}
	
	public function get_isLoggedIn()
	{
		return $this->userIsLoggedIn;
	}
	
	public function get_isAdmin()
	{
		return $this->userIsAdmin;
	}
	
	public function get_userTitle()
	{
		return $this->userTitle;
	}
	
	// SET
	public function set_userSession($sessToken)
	{
		$_SESSION['userId'] = $this->userId;
		$_SESSION['sessToken'] = $sessToken;
	}
	
	public function set_userName($name)
	{
		$this->userName = $name;
	}
	
	public function set_userPassword($password)
	{
		$this->userPassword = $password;
	}
	
	public function set_userEmail($email)
	{
		$this->userEmail = $email;
	}
	
	public function set_isLoggedIn($status)
	{
		$this->userIsLoggedIn = $status;
		
		if (!$status)
		{
			unset($_SESSION['userId']);
			unset($_SESSION['sessToken']);
		}
	}
	
	public function set_isAdmin($status)
	{
		$this->userIsAdmin = $status;
	}
	
	public function set_userTitle($title)
	{
		$this->userTitle = $title;
	}
	
	public function set_logout()
	{
		session_unset();
		session_destroy();
	}
}