<?php 
	
	// Ajoute une réference à tout les controller du CMS
	// TODO : A modifier
	foreach (glob("cms/controller/*Controller.php", GLOB_ERR) as $pathFile) {
		require_once("".$pathFile."");
	}
	require_once("error.php");
	require_once("init.php");

	class Cms 
	{

		private $Url;
		private $SiteSection;
		private $Object;
		private $ControllerMatch;
		private $BadUri;
		private $Content;
		private $ErrorClass;
		private $ErrorCatch;

		/******
		*	Constructeur public
		*	Initialise une nouvelle instance de CMS
		*/
		public function Cms(){
			$this->Url = $_SERVER['REQUEST_URI'];
			$this->SiteSection = array('admin', 'section01', 'section02', 'section03');
			$this->ControllerMatch = false;
			$this->Content = "";
			$this->ErrorClass = null;
			$this->ErrorCatch = null;
		}

		/******
		*	Fonction Main : affiche le contenu de la page 
		*		Initialise une nouvelle instance de CMS
		*/
		public function Main(){

			$parameters = $this->getUrlParameters($this->Url);
			$parametersCount = count($parameters);
			$serverError = false;
			
			// Controller
			if($parametersCount >=0 && $parametersCount < 2){
				foreach ($this->SiteSection as $key => $value) {
					// TODO déclaration du controller
				}	
			}

			// Action ou affichage d'un POST
			if($parametersCount == 2){
				echo "Detecter si on a une action associé ou l'affichage d'un patterne";
			}

			// Aucuns parametres détectés, url de l'index
			if($parametersCount == 0) {
				$Object = new IndexController();
				$this->ControllerMatch = true;			
				$this->Content = $Object->Index();
			}

			// On récupére les erreures et on envois un message
			$this->ErrorCatch = error_get_last();
			if($this->ErrorCatch != null)
				$this->ErrorClass = new CmsError($this->ErrorCatch);
			
			// Status Code
			$this->StatuCode($this->ControllerMatch);	
			
			// Affichage de la donnée
			return $this->Content;
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
		
		/**
		* Définit le Status Code de la page
		*	@param $pageStatus : status retourné par le controlleur de la page
		*	@return void
		*/
		private function StatuCode($pageStatus)
		{
			If($pageStatus == true)
				header($_SERVER["SERVER_PROTOCOL"],200);
			else
				header($_SERVER["SERVER_PROTOCOL"],404);
			if($pageStatus == true){
				header($_SERVER["SERVER_PROTOCOL"]." Ok",200);
				
			}
			else{
				header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found",404);
				$this->Content = file_get_contents("cms/view/404.php");
			}
		}
	}

?>