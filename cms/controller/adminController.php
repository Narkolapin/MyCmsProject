<?php

	class Admin
	{
//index.php?controller=$1&on=$2&doaction=$3&to=$4
		private $AdminActions;
		private $On;
		private $DoAction;
		private $To;


		public function Admin()
		{
			$this->AdminActions =  array('add', 'update', 'delete');
			
			if (isset($_GET['on']) && $_GET['on'] != "")
				$this->On = $_GET['on'];
			if (isset($_GET['doaction']) && $_GET['doaction'] != "")
				$this->DoAction = $_GET['doaction'];
			if (isset($_GET['to']) && $_GET['to'] != "")
				$this->To = $_GET['to'];
		}

		
		public function Home(){
				return "Coucou Admin";
		}


		/**
		* Appel des action dans les controller
		*
		* @param parameters : parametres de l'url
		* @return la vue de l'action
		*
		*****/
		public function CallAction(){

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