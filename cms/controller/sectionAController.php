<?php


class SectionA {

	private $ViewPath = "cms/view/sectionA/home.php" ;
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
}

?>