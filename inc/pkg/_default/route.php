<?php

class Route
{
	private $pathAction;
	private $pathController;
	private $pathParams;
	private $requestUrl;
	private $dbc;
	
	public function __construct($dbc)
	{
		$this->dbc = $dbc;
		if (isset($_SERVER["REQUEST_URI"]))
		{
			$this->requestUrl =  strtolower(trim($_SERVER["REQUEST_URI"]));
		}
		
		$this->pathController = 'index';
		$this->pathAction = 'default';
		$this->pathParams = array();
		
		$this->requestUrl = strtok($this->requestUrl, '?');
		if (substr($this->requestUrl, 0, strlen(INSTALL_PATH)) == INSTALL_PATH)
		{
            $this->requestUrl = substr($this->requestUrl, strlen(INSTALL_PATH));
        } 
		
		$this->parseRequest($this->dbc);
	}
	
	public function load()
	{
		$con = $this->pathController;
		$trol = new $con($this->dbc);
		call_user_func_array([$trol, 'interceptRequest'], array($this->pathAction, $this->pathParams));
		
	}
	
	private function parseRequest($dbc)
	{
		// Split into controller/action array
		$url = $this->requestUrl;
		$parsedRequest = (!empty($url))? explode("/",filter_var(rtrim($url), FILTER_SANITIZE_URL)) : $url;
		
		// Account for extra slashes
		$fixedRequest = [];
		if (is_array($parsedRequest))
		{
			foreach ($parsedRequest as $index=>$parsed)
			{
				if ($parsed=='' || $parsed == null)
				{
					unset($parsedRequest[$index]);
				}
				else
				{
					array_push($fixedRequest,$parsed);
				}
			}
			$parsedRequest = $fixedRequest;
			
			if (count($parsedRequest) > 0)
			{
				// Time to fetch the controller
				if (file_exists('./inc/pkg/_controllers/'.$parsedRequest[0].'.php'))
				{
					// Controller exists
					$this->pathController = $parsedRequest[0];
					if (isset($parsedRequest[1]))
					{
						if (Method_Exists(new $parsedRequest[0]($dbc), $parsedRequest[1]) &&
							$parsedRequest[1] != 'default')
						{
							// Non-default action exists in controller
							$this->pathAction = $parsedRequest[1];
							
							$refAction = new \ReflectionMethod($parsedRequest[0],$parsedRequest[1]);
							if ($refAction->getNumberOfParameters() == (count($parsedRequest)-2))
							{
								// Number of paramaters match, drop controller and action from paramters
								unset($parsedRequest[0]);
								unset($parsedRequest[1]);
								
								$this->pathParams = $parsedRequest ? array_values($parsedRequest) : array();
								unset($parsedRequest);
							}
							else
							{
								// No action with that many paramaters
								$this->pathController = 'not_found';
								$this->pathAction = 'default';
								unset($parsedRequest);
							}
						}
						else
						{
							// No action with that name
							$this->pathController = 'not_found';
							unset($parsedRequest);
						}
					}
					elseif (!Method_Exists(new $parsedRequest[0]($dbc), 'default'))
					{
						// Controller doesn't contain a default action
						$this->pathController = 'not_found';
					}
				}
				else
				{
					// Controller not found
					$this->pathController = 'not_found';
					unset($parsedRequest);
				}
			}
		}
	}
}