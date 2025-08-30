<?php
namespace ParafusoDixital\EtherRain\Model;

class EtherRain
{
	private $_url;
	private $_username;
	private $_password;

	function __construct($url, $username, $password)
	{
		$this->_url = $url;
		$this->_username = $username;
		$this->_password = $password;
	}

	public function getUrl()
	{
		return $this->_url;
	}

	public function setUrl($url)
	{
		$this->_url = $url;
	}

	public function getUsername()
	{
		return $this->_username;
	}

	public function setUsername($username)
	{
		$this->_username = $username;
	}

	public function getPassword()
	{
		return $this->_password;
	}

	public function setPassword($password)
	{
		$this->_password = $password;
	}

	public function __toString()
	{
		return
			"[EtherRain] = " .
			"URL: $this->_url; Username: $this->_username; " .
			"Password: $this->_password";
	}
}