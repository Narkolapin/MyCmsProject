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
			$this->Content = null;
			$this->ErrorClass = null;
			$this->ErrorCatch = null;
			
			// Appels des fonctions
			$this->Main();
		}

		/******
		*	Fonction Main : affiche le contenu de la page 
		*	Initialise une nouvelle instance de CMS
		*/
		private function Main(){

			if (isset($_GET['controller']) && $_GET['controller'] != "")
				$controller = $_GET['controller'];
			if (isset($_GET['patterne']) && $_GET['patterne'] != "")
				$patterne = $_GET['patterne'];

			
			//$parameters = $this->getUrlParameters($this->Url);
			//$parametersCount = count($parameters);
			$serverError = false;
			$Object = null;



			// Controller
			if(isset($controller))
			{
				foreach ($this->SiteSection as $key => $value) {
					if(preg_match("/".$value."/",$controller) && is_file("cms/controller/".$controller."Controller.php")) {
						$objName = ucfirst($controller);
						$Object = new $objName();
						// Si on a qu'un seul paramétre dans l'url
						if(!isset($patterne)) {
							$this->Content = $Object->Home();
							if($this->Content != null)
								$this->ControllerMatch = true;
						}
						break;
					}
				}
			}

			// Action ou affichage d'un POST
			if(isset($controller) && isset($patterne)){

				// Admin
				if(!is_null($Object) && $controller == "admin" && isset($patterne)){
					$this->Content = $Object->CallAction($parameters, $this->SiteSection);
					if($this->Content != null)
						$this->ControllerMatch = true;
				}				
				
				// Pattern by name
				elseif(!is_null($Object) && isset($controller) && preg_match("/^[a-zA-Z0-9-]*$/", $patterne) == 1){
					$this->Content = $Object->GetElementByName($patterne);
					if($this->Content != null)
						$this->ControllerMatch = true;
				}

				// Pattern by Id
				elseif(!is_null($Object) &&  isset($controller) && preg_match("/^[0-9]*$/", $patterne)){
					$this->Content = $Object->GetElementById($patterne);
					if($this->Content != null)
						$this->ControllerMatch = true;
				}

				// Pas d'objet
				else
					$this->ControllerMatch = false;
			}

			// Aucuns parametres détectés, url de l'index
			if(!isset($controller) && !isset($patterne)) {
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