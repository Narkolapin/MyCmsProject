<?php

	class Admin
	{
		private $AdminActions;
		private $On;
		private $DoAction;
		private $To;
		private $Method;


		public function Admin()
		{
			$this->AdminActions =  array('add', 'update', 'delete');
			$this->Method = $_SERVER['REQUEST_METHOD'];
			
			if (isset($_GET['on']) && $_GET['on'] != "")
				$this->On = $_GET['on'];
			if (isset($_GET['doaction']) && $_GET['doaction'] != "")
				$this->DoAction = $_GET['doaction'];
			if (isset($_GET['to']) && $_GET['to'] != "")
				$this->To = $_GET['to'];
		}

		
		public function Home(){
				return "Ici, prochainement, la page admin";
		}


		/**
		* Appel des action dans les controller
		*
		* @param object $objectController : objet représentant le controller
		* @return la vue de l'action
		*
		*****/
		public function CallAction($objectController){
			global $debeug;

			if($debeug){
				echo "<br/>Debeug de la méthode CallAction() <br />";
				var_dump(
					//$objectController,
					$this->On,
					$this->DoAction,
					$this->To
				);

			}
			// Si on a bien un controller de destination
			if(isset($this->On)) {
			
				// Appel de l'index admin du controller
				if(!isset($this->DoAction))
					return $objectController->Admin();

				// Add
				if(isset($this->DoAction) && $this->DoAction == "add")
					return $objectController->Add($this->Method);

				// Delete or Edit
				if(isset($this->On) && isset($this->DoAction) && isset($this->To)){
					if($this->DoAction == "delete")
						return $objectController->Delete(1, $this->Method);
					
					if($this->DoAction == "edit")
						return $objectController->Edit(1, $this->Method);
				}
			}
			return null;
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




	}
?> 