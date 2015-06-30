<?php
include("/cms/model/sectionAModel.php");
include("/cms/bin/MySQLTools.php");
include("/cms/bin/init.php");

class SectionA {

	private $viewFolder;
	private $ViewPath = "cms/view/sectionA/index.php" ;
	private $View;

	public function SectionA()
	{
		$this->View = file_get_contents($this->ViewPath);
		$this->viewFolder = "cms/view/". strtolower(get_class($this)) ."/";
	}


	public function Home()
	{
		return $this->View;
	}


	public function GetElementByName($pattern){
		return "Retour de la SectionA avec un pattern : ". $pattern;
	}

	public function GetElementById($id){
		return "Retour de la fonction avec un id : ". $id;
	}

	public function Admin(){
		return 'Page d\'administration de la sectionA';
	}

	public function Add($method){
		
		if($method == "POST"){
				$host = "127.0.0.1";			// TODO :  a déplacer
				$userBdd = "root";				// TODO :  a déplacer	
				$pwdBdd = "";					// TODO :  a déplacer
			$mysql = new MySQLTools($host,$userBdd,$pwdBdd, "cms");
			$mysql->Insert(new sectionAModel($_POST));
			return 'Page ajouter';
		}
		
		if($method == "GET"){
			$this->viewFolder = $this->viewFolder."add.php";
			return file_get_contents($this->viewFolder);
		}
		return null;
	}

	public function Edit($id, $method){
		if($method == "POST")
			return 'Page'. $id .'edité';
		if($method == "GET")
			return 'Page pour edité '. $id;
		return null;
	}

	public function Delete($id, $method){
		if($method == "POST")
			return 'Page '.$id.' suprimer';
		if($method == "GET")
			return 'Page pour suprimer'.$id;
		return null;
	}
}

?>