<?php

interface IController
{
	/***********************
	* Affiche la page d'accueil du controller 
	**********************/
	public function Home();

	/***********************
	* Affiche le contenus de l'objet en fonction de son pattern 
	**********************/
	public function GetElementByName($pattern);

	/***********************
	* Affiche le contenus de l'object en fonctiond de son Id
	**********************/
	public function GetElementById($id);

}