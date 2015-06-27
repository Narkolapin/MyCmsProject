<?php

interface IController
{
	/**
	* Affiche la page d'accueil du controller 
	**********************/
	public function Home();

	/**
	* Affiche le contenus de l'objet en fonction de son pattern
	* @param string $pattern : patterne à analyser (string)
	* @return le contenu de l'objet 
	**********************/
	public function GetElementByName($pattern);

	/**
	* Affiche le contenus de l'object en fonctiond de son Id
	* @param int $id : identifiant de l'objet
	* @return le contenu de l'objet 
	**********************/
	public function GetElementById($id);

	/**
	* Methode pour afficher la page d'index d'administation du controller
	* @return view admin.php
	**********************/
	public function Admin();

	/**
	* Methode pour ajouter un entité de la base du controller
	* @param string $method : methode de la requéte d'acces
	* @return [GET] Affiche le formulaire
	* @return [POST] Envois le formulaire en Bdd
	**********************/
	public function Add($method);

	/**
	* Methode pour modifier une entité de la base du controller
	* @param int $id 		: identifiant de l'entité
	* @param string $method : methode de la requéte d'acces
	* @return [GET] Affiche le formulaire chargés avec l'entitée
	* @return [POST] Envois le formulaire en Bdd
	**********************/
	public function Edit($id, $method);

	/**
	* Methode pour supprimer une entité de la base du ctrl
	* @param int $id 		: identifiant de l'entité
	* @param string $method : methode de la requéte d'acces
	* @return [POST] Supprime l'entité avec l'id => $id
	**********************/
	public function Delete($id, $method);

}