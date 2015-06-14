<?php

interface IController
{
	/**
	* Affiche la page d'accueil du controller 
	**********************/
	public function Home();

	/**
	* Affiche le contenus de l'objet en fonction de son pattern
	* @param patterne à analyser (string)
	* @return le contenu de l'objet 
	**********************/
	public function GetElementByName($pattern);

	/**
	* Affiche le contenus de l'object en fonctiond de son Id
	* @param identifiant de l'objet (int)
	* @return le contenu de l'objet 
	**********************/
	public function GetElementById($id);

}