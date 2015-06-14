<?php 
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
			$this->SiteSection = array('admin', 'sectionA', 'sectionB', 'sectionC');
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
			$Object = null;

			// Controller
			if($parametersCount >= 1 && $parametersCount <= 2){
				foreach ($this->SiteSection as $key => $value) {
					if(preg_match("/".$value."/",$parameters[0]) && is_file("cms/controller/".$parameters[0]."Controller.php")) {
						$objName = ucfirst($parameters[0]);
						$Object = new $objName();
						// Si on a qu'un seul paramétre dans l'url
						if($parametersCount == 1) {
							$this->ControllerMatch = true;
							$this->Content = $Object->Home();
						}
						break;
					}
				}
			}

			// Action ou affichage d'un POST
			if($parametersCount == 2){

				// Admin
				if(!is_null($Object) && $parameters[0] == "admin" && isset($parameters[1])){
					$this->Content = $Object->CallAction($parameters, $this->SiteSection);
					if($this->Content != "")
						$this->ControllerMatch = true;
				}				
				
				// Pattern by name
				elseif(!is_null($Object) && isset($parameters[1]) && preg_match("/^[a-zA-Z0-9-]*$/", $parameters[1]) == 1){
					$this->Content = $Object->GetElementByName($parameters[1]);
					if($this->Content != "")
						$this->ControllerMatch = true;
				}

				// Pattern by Id
				elseif(!is_null($Object) &&  isset($parameters[1]) && preg_match("/^[0-9]*$/", $parameters[1])){
					$this->Content = $Object->GetElementById($parameters[1]);
					if($this->Content != "")
						$this->ControllerMatch = true;
				}

				// Pas d'objet
				else
					$this->ControllerMatch = false;
			}

			// Aucuns parametres détectés, url de l'index
			if($parametersCount == 0) {
				$Object = new IndexController();
				$this->ControllerMatch = true;			
				$this->Content = $Object->Home();
			}

			// On récupére les erreures et on envois un message
			$this->ErrorCatch = error_get_last();
			if($this->ErrorCatch != null)
				$this->ErrorClass = new CmsError($this->ErrorCatch);
			
			// Status Code
			$this->StatuCode($this->ControllerMatch);
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
		private function StatuCode($pageStatus) {
			if($pageStatus == true)
				header($_SERVER["SERVER_PROTOCOL"]." 200 OK", 200);

			else {
				header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found",404);
				$this->Content = file_get_contents("cms/view/404.php");
			}
		}

		/**
		* GETTER de Content
		*	@return la valeure de la propriété $Content de la class CMS
		*/
		public function GetContent() {
			return $this->Content;
		}
	}

?>