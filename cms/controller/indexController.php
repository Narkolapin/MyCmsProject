<?php
	
	class IndexController implements IController
	{

		private $ViewPath = "cms/view/accueil.php" ;
		private $View;

		public function IndexController()
		{
			$this->View = file_get_contents($this->ViewPath);
		}


		public function Home()
		{
			return $this->View;
		}

		public function GetElementByName($pattern){
			return null;

		}

		public function GetElementById($id){
			return null;
		}
	}
?>