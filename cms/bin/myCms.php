<?php 
	require_once("init.php");

	class Cms 
	{
		private $SiteSection;
		private $Object;
		private $ControllerMatch;
		private $BadRequest;
		private $Content;
		private $ErrorClass;
		private $ErrorCatch;

		/******
		*	Constructeur public
		*	Initialise une nouvelle instance de CMS
		*/
		public function Cms(){
			$this->SiteSection = array('admin', 'sectionA', 'sectionB', 'sectionC'); //Bdd
			$this->ControllerMatch = false;
			$this->Content = null;
			$this->ErrorClass = null;
			$this->ErrorCatch = null;
			$this->BadRequest = false;

			$this->Main();
		}

		/******
		*	Fonction Main : affiche le contenu de la page 
		*	Initialise une nouvelle instance de CMS
		*/
		private function Main(){

			if (isset($_GET['controller']) && $_GET['controller'] != "")
				$controller = $_GET['controller'];
			if (isset($_GET['pattern']) && $_GET['pattern'] != "")
				$pattern = $_GET['pattern'];
			if (isset($_GET['on']) && $_GET['on'] != "")
				$on = $_GET['on'];

			$Object = null;
			global $debeug;

			// Controller
			if(isset($controller))
			{
				$Object = $this->IsController($controller);

				if(!isset($pattern) && !isset($on) && isset($Object)) {
					$launch = true;
					// Vérification des droits pour la partie admin
					if($controller == "admin" && !$this->IsAdmin("admin", "active")){
						$launch = false;
						$this->BadRequest = true;
					}
					// Création de l'Objet
					if($launch) {
						$this->Content = $Object->Home();
						if($this->Content != null)
							$this->ControllerMatch = true;
					}
				}
			}

			// Admin
			if(isset($controller) && isset($on)){
				if(!is_null($Object) && $controller == "admin"){
					$onController = $this->IsController($on);
					if(isset($onController)){
						$this->Content = $Object->CallAction($onController);
						if($this->Content != null)
							$this->ControllerMatch = true;
					}
				}			
			}

			// Action ou affichage d'un POST
			if(isset($controller) && isset($pattern)){

				// Pattern by name
				if(!is_null($Object) && isset($controller) && preg_match("/^[a-zA-Z0-9-]*$/", $pattern) == 1){
					$this->Content = $Object->GetElementByName($pattern);
					if($this->Content != null)
						$this->ControllerMatch = true;
				}

				// Pattern by Id
				elseif(!is_null($Object) &&  isset($controller) && preg_match("/^[0-9]*$/", $pattern)){
					$this->Content = $Object->GetElementById($pattern);
					if($this->Content != null)
						$this->ControllerMatch = true;
				}

				// Pas d'objet
				else
					$this->ControllerMatch = false;
			}

			// Aucuns parametres détectés, url de l'index
			if(!isset($controller) && !isset($pattern) && count($_GET) != 0) {
				$Object = new IndexController();
				$this->ControllerMatch = true;			
				$this->Content = $Object->Home();
			}

			// On récupére les erreures et on envois un message
			$this->ErrorCatch = error_get_last();
			if($this->ErrorCatch != null)
				$this->ErrorClass = new CmsError($this->ErrorCatch);
			
			// Status Code
			$this->StatuCode($this->ControllerMatch, $this->BadRequest);

			if($debeug){
				var_dump(
					//isset($controller), 
					//isset($pattern),
					//isset($on),
					//$Object, 
					$_GET, 
					//count($_GET), 
					//$this->ControllerMatch,
					//$on,
					$this->BadRequest
					);
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


		/**
		* GETTER de Content
		*	@return la valeure de la propriété $Content de la class CMS
		*/
		public function GetContent() {
			return $this->Content;
		}
		
		/**
		* Définit le Status Code de la page
		*	@param $pageStatus : bool passé à true si un controller retourne une valeure pour contenus
		*	@param $badRequest : bool passé a true si les droits d'access sont insufisants
		*	@return le status code de la page dans le header 
		*/
		private function StatuCode($pageStatus, $badRequest) {
			if(!$badRequest){
				if($pageStatus == true)
					header($_SERVER["SERVER_PROTOCOL"]." 200 OK", 200);

				else {
					header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", 404);
					$this->Content = file_get_contents("cms/view/404.php");
				}
			}
			else
			{
				header($_SERVER["SERVER_PROTOCOL"]." 403 Forbiden", 403);
				$this->Content = file_get_contents("cms/view/403.php");
			}
		}

		/**
		* Determine si l'utilisateur est administrateur
		*
		* @param status : status du compte utilisateur
		* @param session : etat de la session
		* @return un boolean représentant l'autorisatio d e l'accès à l'administration.
		*
		****************/
		private function IsAdmin($status, $session){

			if($status == "admin" && $session == "active")
				return true;
			else
				return false;
		}

		/**
		* Determine si le parametre $_GET['controller'] existe
		*
		* @param string $varCtrlName : nom du controller a tester
		* @return object $Object : objet du controller
		*
		****************/
		private function IsController($varCtrlName){
			global $debeug;
			foreach ($this->SiteSection as $key => $value) {
				if($debeug)
					echo "Check : ".$value." avec ". $varCtrlName ." is match => ".preg_match("/".$value."/",$varCtrlName)." is file : ".is_file("cms/controller/".$varCtrlName."Controller.php")."<br/>";
				if(preg_match("/".$value."/",$varCtrlName) && is_file("cms/controller/".$varCtrlName."Controller.php")) {
					$objName = ucfirst($varCtrlName);
					return $Object = new $objName();
				}
			}
			return null;
		}
	}
?>