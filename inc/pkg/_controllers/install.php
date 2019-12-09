<?php

class Install extends Controller
{
    public function __construct($dbc)
    {
        parent::__construct($dbc);
    }
    
    protected function default()
    {
        $this->start();
    }
    
    protected function start()
    {
        include 'web/install/start.view';
        exit;
    }
	
	protected function site()
	{
		include 'web/install/site.view';
		exit;
	}
	
	protected function user()
	{
		include 'web/install/user.view';
		exit;
	}
	
	protected function set($type)
	{
		switch($type)
		{
			case 'site':
				if (isset($_POST['siteUrl']) && 
					strlen($_POST['siteUrl']) > 12 && 
					isset($_POST['siteName']) &&
					isset($_POST['siteTagline']))
				{
					$url = trim($_POST['siteUrl']);
					$name = trim($_POST['siteName']);
					$tagline = trim($_POST['siteTagline']);
					$allowregister = (isset($_POST['siteAllowRegister']) && $_POST['siteAllowRegister'] == 'Allow');
					
					$site = new Site();
					$site->set_siteUrl($url);
					$site->set_siteName($name);
					$site->set_siteTagline($tagline);
					$site->set_allowUserRegister($allowregister);
					
					if(!$this->siteModel->set_isInstalled($site))
					{
						echo "There was a problem during database installation.";
						exit();
					}
					
					header('Location: ' . $this->site->get_siteUrl(). '/install/user');
				}
				else
				{
					$this->site();
				}
				break;
			case 'user':
				if (isset($_POST['userName']) &&
					isset($_POST['userPass']) &&
					isset($_POST['userPass2']) &&
					isset($_POST['userEmail']))
				{
					$username = trim($_POST['userName']);
					$password = $_POST['userPass'];
					$email = trim($_POST['userEmail']);
					
					$gooduser = true;
					if(strlen($username) < 3) $gooduser = false;
					if(strlen($password) < 10) $gooduser = false;
					
					if($gooduser)
					{
						$user = new User();
						$user->set_userName($username);
						$user->set_userPassword(password_hash($password, PASSWORD_DEFAULT));
						$user->set_userEmail($email);
						$user->set_isAdmin(true);
						$user->set_userTitle("Administrator");
						if ($this->userModel->register($user))
						{
							header('Location: ' . $this->site->get_siteUrl());
						}
						else
						{
							$this->user();
						}
					}
					else
					{
						$this->user();
					}
				}
				break;
		}
	}
}