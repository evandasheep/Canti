<?php

class Login extends Controller
{
    public function __construct($dbc)
    {
        parent::__construct($dbc);
    }
    
    protected function default()
    {
		$retUrl = (isset($_GET['returnUrl'])) ? $this->site->get_siteUrl().trim($_GET['returnUrl']) : $this->site->get_siteUrl();
		if ($this->user->get_isLoggedIn()) header('Location: '.$retUrl);
		
		if (isset($_POST['userName']) && isset($_POST['userPass']))
		{
			$user = new User();
			$user->set_userName(trim($_POST['userName']));
			$user->set_userPassword($_POST['userPass']);
			
			if ($this->userModel->login($user))
			{
				header('Location: '.$retUrl);
			}
		}
		
        include 'web/login.view';
    }
}
?>