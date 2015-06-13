<?php
	require_once("error.php");

	// Ajoute une réference à tout les controller du CMS
	// TODO : A modifier
	foreach (glob("cms/controller/*Controller.php", GLOB_ERR) as $pathFile) {
		require_once("".$pathFile."");
	}

	
	//ini_set("error_reporting", 0);	//Récupére toutes les erreures
	//ini_set("display_errors", 1);	// Affiche (ou non) toutes les erreures à l'ecran
?>