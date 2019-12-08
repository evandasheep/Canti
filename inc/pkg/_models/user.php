<?php

class UserModel extends Model
{
    public function __construct($dbc)
    {
        $this->dbc = $dbc;
    }
    
	public function get_userObject($id)
	{
		$result = $this->getById('users', $id);
		if ($result)
		{
			$user = new User();
			$user->constructObject(
				$result['id'],
				$result['username'],
				$result['password'],
				$result['email'],
				$result['is_admin'],
				$result['title']
			);
			return $user;
		}
		else
		{
			return false;
		}
	}
	
	public function get_sessionStatus($sessionData)
	{
		if(!$sessionData)
		{
			return false;
		}
		else
		{
			$result = $this->getById('site_sessions', $sessionData[1]);
			if(!$result)
			{
				return false;
			}
			else
			{
				return ($result['userId'] == $sessionData[0]
						&& $result['expire'] > $_SERVER['REQUEST_TIME']);
			}
		}
	}
	
	public function login($userObject)
	{
		$user = new User();
		
		$result = $this->getByParam('users', 'username', $userObject->get_userName());
		if (count($result) == 1)
		{
			$user->constructObject(
				$result['id'],
				$result['username'],
				$result['password'],
				$result['email'],
				$result['is_admin'],
				$result['title']
			);
			
			if (password_verify($userObject->get_userPassword(), $user->get_userPassword()))
			{
				$user->set_userSession($this->get_newSessToken($user));
				$this->set_sessionToken($user);
				return true;
			}
			else
			{
				// Wrong password
				return false;
			}
		}
		else
		{
			// User not found
			return false;
		}
	}
	
	public function get_newSessToken($user)
	{
		$token = password_hash($user->get_userName().$_SERVER['REQUEST_TIME'].uniqid(), PASSWORD_DEFAULT);
		return $token;
	}
	
	public function set_sessionToken($user)
	{
		$expire = $_SERVER['REQUEST_TIME'] + 86400;
		$sql = "INSERT INTO site_sessions (`id`, `userId`, `created`, `expire`) VALUES (:id, :userId, :created, :expire)";
		try
		{
			$stmt = $this->dbc->prepare($sql);
			$stmt->bindValue(':id', $user->get_userSession()[1]);
			$stmt->bindValue(':userId', $user->get_userId());
			$stmt->bindValue(':created', $_SERVER['REQUEST_TIME']);
			$stmt->bindValue(':expire', $expire);
			$stmt->execute();
		}
		catch(Exception $e)
		{
			echo "Error inserting new session.";
		}
	}
	
	public function register($user)
	{
		$sql = "INSERT INTO users (`username`, `password`, `email`, `is_admin`, `title`) VALUES (:username, :password, :email, :admin, :title)";
		try
		{
			$stmt = $this->dbc->prepare($sql);
			$stmt->bindValue(':username', $user->get_userName());
			$stmt->bindValue(':password', $user->get_userPassword());
			$stmt->bindValue(':email', $user->get_userEmail());
			$stmt->bindValue(':admin', $user->get_isAdmin());
			$stmt->bindValue(':title', $user->get_userTitle());
			$stmt->execute();
			if($stmt->rowCount() == 1)
			{
				return true;
			}
		}
		catch (Exception $e)
		{
			return false;
		}
	}
}