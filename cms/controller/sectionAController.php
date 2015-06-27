<?php


class SectionA {

	private $ViewPath = "cms/view/sectionA/index.php" ;
	private $View;

	public function SectionA()
	{
		$this->View = file_get_contents($this->ViewPath);
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
		if($method == "POST")
			return 'Page ajouter';
		if($method == "GET")
			return 'Page pour ajouter';
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