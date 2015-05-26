<?php
	
	class IndexController
	{

		private $ViewPath = "cms/view/accueil.php" ;
		private $View;

		public function IndexController()
		{
			$this->View = file_get_contents($this->ViewPath);
		}


		public function Index()
		{
			return $this->View;
		}

	}
?>