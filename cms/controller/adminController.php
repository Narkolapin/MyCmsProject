<?php

	class Admin
	{

		private $AdminActions;


		public function Admin()
		{
			$this->AdminActions =  array('add', 'update', 'delete');
		}

		
		public function Home(){
			
			if($this->IsAdmin("admin", "active"))
				return "Coucou Admin";

		}


		/**
		* Appel les action dans les controller
		*
		* @param parameters : parametres de l'url
		* @return la vue de l'action
		*
		*****/
		public function CallAction($parameters, $sectionSite){

			if(!$this->IsAdmin("admin", "active"))									// IsAdmin
				return;
			if(count($parameters < 2))												// Deux param a analyser
				return;
			if(empty($_GET['ctrl']) || empty($_GET['act']))							// Parametres GET obligatoirs
				return;
			if(!in_array($_GET['ctrl'], $sectionSite))								// aucun controller connus
				return;
			if(!in_array($_GET['act'], $this->AdminActions))						// aucunes actions connus
				return;
		}

		private function getParameters(){


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