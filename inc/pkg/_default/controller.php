<?php

class Controller
{
    protected $site;
	protected $siteModel;
	protected $user;
	protected $userModel;
	
	protected $pageTitle;
    protected $bodyId;
    
	public function __construct($dbc)
	{
	    $this->dbc = $dbc;
		$this->siteModel = new SiteModel($dbc);
		$this->site = $this->siteModel->get_siteObject();
		
		$this->userModel = new UserModel($dbc);
		$this->user = new User();
		
		$sessionData = $this->user->get_userSession();
		if ($this->userModel->get_sessionStatus($sessionData))
		{
			$this->user = $this->userModel->get_userObject($this->user->get_id());
			$this->user->set_isLoggedIn(true);
		}
		else
		{
			$this->user->set_isLoggedIn(false);
		}
	}
	
    public function get_viewTitle()
    {
        return $this->pageTitle;
    }
    
    public function get_viewBody()
    {
        return $this->bodyId;
    }
    
    public function set_viewBody($bodyId)
    {
        $this->bodyId = $bodyId;
    }
    
    public function set_methodName($name)
    {
        define('__VIEW__', $name);
    }
    
    public function interceptRequest($action, $params)
	{
		if ($this->siteModel->get_isInstalled())
		{
			$this->set_methodName($action);
			$this->bodyId = 'home';
			
			if ($this->site->get_siteStatus())
			{
				if (get_class($this) != 'Install')
				{
					// Proceed to requested content
					call_user_func_array([new $this($this->dbc), $action], $params);
				}
				else
				{
					// Do not allow installation to be called if site is already setup.
					call_user_func_array([new Not_Found($this->dbc), 'default'], array());
				}
			}
			else
			{
				// Maintenance Mode
				$this->pageTitle = "Under Maintenance";
				include 'web/maintenance/index.view';
				exit;
			}
		}
		else
		{
			if (get_class($this) != 'Install')
			{
				// Redirect to installer
				header('Location: ' . $this->site->get_siteUrl(). '/install/start');
			}
			else
			{
				// Proceed to installer
				call_user_func_array([new $this($this->dbc), $action], $params);
			}
		}
	}
}