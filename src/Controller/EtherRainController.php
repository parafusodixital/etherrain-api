<?php
namespace ParafusoDixital\EtherRain\Controller;

class EtherRainController
{
	private $_etherRain;

	public function __construct($etherRain)
	{
		$this->_etherRain = $etherRain;
	}

	public function login()
	{
		$loginurl = 
		  "ergetcfg.cgi?lu=" . $this->_etherRain->getUsername() . "&lp=" . $this->_etherRain->getPassword();
		
		$ch = curl_init($this->_etherRain->getUrl() . $loginurl);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		
		!curl_exec($ch);
		
		$curl_errno = curl_errno($ch);
		$curl_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		if (($curl_errno > 0) || (404 == $curl_code))
		{
		    return FALSE;
		} else {
		    return TRUE;
		}

		curl_close($ch);
	}

	public function status()
	{
		$etherRainStatus = NULL;
		$statusurl = "result.cgi?xs";
		$ch = curl_init($this->_etherRain->getUrl() . $statusurl);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		
		$result = curl_exec($ch);
		
		$curl_errno = curl_errno($ch);
		$curl_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		if (($curl_errno == 0) && (200 == $curl_code)) {
		    $etherRainStatus = new EtherRainStatus($result);
		} else {
		    return NULL;
		}
		
		curl_close($ch);

		return $etherRainStatus;		
	}
	
	public function irrigate($delay, $valvesTime)
	{
	    $etherRainStatus = NULL;
	    $aux = implode(":", $valvesTime);
	    $irrigateurl = "result.cgi?xi=$delay:$aux";
	    $ch = curl_init($this->_etherRain->getUrl() . $irrigateurl);
	    
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	    
	    $result = curl_exec($ch);

	    $curl_errno = curl_errno($ch);
	    $curl_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    
	    if (($curl_errno == 0) && (200 == $curl_code)) {
	        $etherRainStatus = new EtherRainStatus($result);
	    } else {
	        return NULL;
	    }
	    curl_close($ch);
	    
	    return $etherRainStatus;
	}
}