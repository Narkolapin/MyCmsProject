<?php
include("/cms/model/sectionAModel.php");
include("/cms/bin/MySQLTools.php");
include("/cms/bin/init.php");

class SectionA {

	private $viewFolder;
	private $ViewPath = "cms/view/sectionA/index.php" ;
	private $View;
	private $mysql = null;
	private $Entity = null;

	public function SectionA() {
		$this->View = file_get_contents($this->ViewPath);
		$this->viewFolder = "cms/view/". strtolower(get_class($this)) ."/";
		
		$host = "127.0.0.1";			// TODO :  a déplacer
		$userBdd = "root";				// TODO :  a déplacer	
		$pwdBdd = "";					// TODO :  a déplacer
		
		$this->mysql = new MySQLTools(
			$host,
			$userBdd,
			$pwdBdd,
			"cms"
		);
	}


	public function Home()
	{
		$view = $this->View;
		
		// Traitement du rendu
		$content = "<ul>";
		foreach ($this->mysql->Select(new sectionAModel()) as $key => $value) {
			$content = $content."<li>Le ".$value->Get_Date()." : ".$value->Get_Text()."</i>";
		}
		$content = $content. "</ul>";
		
		return preg_replace('/@{content}/i',$content, $view);
	}

	/*
	* A fusionner 
	*/
	public function GetElementByName($pattern){
		return "Retour de la SectionA avec un pattern : ". $pattern;
	}

	public function GetElementById($id){
		return "Retour de la fonction avec un id : ". $id;
	}
	/*
	* ------------------------------
	*/

	public function Admin(){
		return 'Page d\'administration de la sectionA';
	}

	public function Add($method) {
		
		// Enregistrement en base
		if($method == "POST")
			$this->mysql->Insert(new sectionAModel($_POST));
		
		// Affichage de la vue
		if($method == "GET") {
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