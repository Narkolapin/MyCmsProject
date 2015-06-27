<?php

/**
* 
*/
class CmsError 
{
	private $Error = null;

	function __construct($catchedError)
	{
		$this->Error = $catchedError;
		register_shutdown_function(array($this, 'CatchFatalError'), $this->Error);
		//var_dump($this->Error);
	}


	public function CatchFatalError($error){
		echo "je passe ici";
		if($error != null){}
			$this->SendErrorLog($error['type'], $error['file'], $error['ligne'], $error['message']);
	}


	public function SendErrorLog($type, $file, $ligne, $message){
		
		echo "je passe la";
		//var_dump($type,$file,$ligne,$message);

		$date = new DateTime('NOW');
		$logs = 
			"\n[".$date->format("Y-m-d | h-i-s")."] Une erreur est survenue : ". $type .
			"\n[".$date->format("Y-m-d | h-i-s")."] Message de l'érreure : ". $message .
			"\n[".$date->format("Y-m-d | h-i-s")."] Localisation : ". $file ." ligne : ". $ligne;
		
		error_log($logs, 0);
	}
}

?>