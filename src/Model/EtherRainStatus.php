<?php
namespace ParafusoDixital\EtherRain\Model;

class EtherRainStatus
{	
	const OPERATING_STATUS = array("WT" => "WAITING", "BZ" => "RUNNING", "RD" => "READY", "RN" => "RAIN");
	const COMMAND_STATUS = array("OK" => "OK", "NA" => "NOT ACCEPTED", "ER" => "FORMAT ERROR");
	const OPERATING_RESULT = array("OK" => "OK", "NC" => "NOT COMPLETED", "SH" => "SHORT");
	const RAIN_INDICATOR = array("0" => "NOT RAINING", "1" => "RAINING");

	// Variable un
	private $_uniqueName;
	// Variable ma
	private $_macAddress;
	// Variable ac (Service account number, if used)
	private $_accountNumber;
	// Variable os (WT: waiting, BZ: running, RD: ready, RN: rain. Indicates which state the device is currently in)
	private $_operatingStatus;
	// Variable cs (OK: ok, NA: not accepted, ER: format error. Indicates if the command was accepted or not)
	private $_commandStatus;
	// Variable rz (OK: ok, NC: not complete; SH: short. Indicates the result of the previous irrigate command issued)
	private $_operatingResult;
	// Variable ri (Indicates the last relay that has finished execution)
	private $_relayIndex;
	// Variable rn (0 or 1. 1 indicates that rain is being detected)
	private $_rainIndicator;

	public function __construct()
	{
		$un = NULL;
		$ma = NULL;
		$ac = NULL;
		$os = NULL;
		$cs = NULL;
		$rz = NULL;
		$ri = NULL;
		$rn = NULL;
		// It recieves HTML String
		if (func_num_args() == 1)
		{
			
			$forbiddenWords = array(
				"<html>", "</html>", "<head>", "</head>", "<body>", 
				"</body>", "\t", "<br>", "EtherRain Device Status", " ");
			$result = str_replace($forbiddenWords, "", func_get_arg(0));

			@$params = explode("\r\n", $result);
			foreach($params AS $param)
			{
				@list($key, $value) = explode(":", $param);
				switch($key)
				{
					case "un": 
						$un = $value;
						break;
					case "ma":
						$ma = $value;
						break;
					case "ac":
						$ac = $value;
						break;
					case "os":
						$os = $value;
						break;
					case "cs":
						$cs = $value;
						break;
					case "rz":
						$rz = $value;
						break;
					case "ri":
						$ri = $value;
						break;
					case "rn":
						$rn = $value;
						break;
					default:
						error_log("KEY: $key not recognized");
						break;
				}
			}
		}
		else if (func_num_args() == 8)
		{
			$un = func_get_arg(0);
			$ma = func_get_arg(1);
			$ac = func_get_arg(2);
			$os = func_get_arg(3);
			$cs = func_get_arg(4);
			$rz = func_get_arg(5);
			$ri = func_get_arg(6);
			$rn = func_get_arg(7);
		}
		$this->_uniqueName = $un;
		$this->_macAddress = $ma;
		$this->_accountNumber = $ac;
		$this->_operatingStatus = $os;
		$this->_commandStatus = $cs;
		$this->_operatingResult = $rz;
		$this->_relayIndex = $ri;
		$this->_rainIndicator = $rn;
	}

	public function getUniqueName() 
	{ 
		return $this->_uniqueName; 
	}
	
	public function getMacAddress() 
	{ 
		return $this->_macAddress; 
	}
	
	public function getAccountNumber() 
	{ 
		return $this->_accountNumber; 
	}
	
	public function getOperatingStatus() 
	{ 
		return $this->_operatingStatus; 
	}
	
	public function getCommandStatus() 
	{ 
		return $this->_commandStatus; 
	}
	
	public function getOperatingResult() 
	{ 
		return $this->_operatingResult; 
	}
	
	public function getRelayIndex() 
	{ 
		return $this->_relayIndex; 
	}
	
	public function getRainIndicator() 
	{ 
		return $this->_rainIndicator; 
	}

	public function __toString()
	{
		return
			"[EtherRainStatus] = " .
				"UniqueName: $this->_uniqueName; MAC Address: $this->_macAddress; " .
				"Account Number: $this->_accountNumber; Operating Status: $this->_operatingStatus; " .
				"Command Status: $this->_commandStatus; Operating Result: $this->_operatingResult; " .
				"Relay Index: $this->_relayIndex; Rain Indicator: $this->_rainIndicator";
	}
}