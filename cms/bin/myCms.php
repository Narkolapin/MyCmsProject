<?php 
	
	// Ajoute une réference à tout les controller du CMS
	// TODO : A modifier
	foreach (glob("cms/controller/*Controller.php", GLOB_ERR) as $filename) {
		require_once("".$filename."");
	}

	class Cms 
	{

		private $Url;

		private $SiteSection;

		private $Object;
		
		private $SectionMatch = false;


		/******
		*	Constructeur public
		*	Initialise une nouvelle instance de CMS
		*/
		public function Cms(){
			$this->Url = $_SERVER['REQUEST_URI'];
			$this->SiteSection = array('admin', 'section01', 'section02', 'section03');
		}

		/******
		*	Fonction Main : affiche le contenu de la page 
		*		Initialise une nouvelle instance de CMS
		*/
		public function Main(){

			$parameters = $this->getUrlParameters($this->Url);

			// Aucuns parametres détectés, url de l'index
			if(empty($parameters)){
				$Object = new IndexController();
				if(!empty($Object))
					$this->SectionMatch = true;
				$this->StatuCode($this->SectionMatch);
				return $Object->Index();
			}
			
		}

		/**
		* Récupére les paramétre d'une url
		* 	@param $url : url à analyser 
		* 	@return un tableau contenant chaques parties de l'url
		*/
		public function getUrlParameters($url){
			
			$getParameters = explode("/",$url);
			$offsetGetParam = 0;
			foreach ($getParameters as $key => $value) {
				if($value == ''){
					array_splice($getParameters, $key-$offsetGetParam, $key-$offsetGetParam+1);
					$offsetGetParam++;
				}
			}
			return $getParameters;
		}
		
		
		
		private function StatuCode($pageStatus)
		{
			If($pageStatus == true)
				header($_SERVER["SERVER_PROTOCOL"],200);
			else
				header($_SERVER["SERVER_PROTOCOL"],404);
		}

	}

?>