<?php

require_once("/cms/model/IModel.php");	

class sectionAModel extends IModel
{
	private $Id;
	private $Text;
	private $Date;

	public function sectionAModel(array $post){
		$this->ModelReflexion($post);
		$this->Id = null;
		$this->Date = date("Y-m-d H:i:s");
	}

	/**
	* Retourne les noms des propriétés de l'objet
	* @param void
	* @return array des propriétés de l'objet avec leur veleur
	*/
	public function GetObjectProperty(){
		return get_object_vars($this);
	}

	/**
	* Assigne les propriétés de la class par reflexion
	* @param array $post : tableau de la requete Post
	* @return void
	*/
	private function ModelReflexion(array $post){
		try 
		{
			$reflectionClass = new ReflectionClass($this); //reflection Php
			foreach ($post as $postKey => $postValue) {
				foreach (get_object_vars($this) as $modelKey => $modeValue) {
					if($postKey == $modelKey){
						$reflexctionProperty = $reflectionClass->getProperty($modelKey);
						$reflexctionProperty->setAccessible(true);
						$reflexctionProperty->setValue($this, $postValue);
					}
				}
			}
		} 
		catch (Exception $e) {
			throw new  Exception("Error Processing Request : ". $e->GetMessage , 1);
		}
	}

	/**
	* Getter & Setter
	* @param Id
	*/
	public function Get_Id() {
		return $this->Id;
	}

	public function Set_Id($value){
		$this->Id = $value;
	}

	/**
	* Getter & Setter
	* @param Text
	*/
	public function Get_Text() {
		return $this->Text;
	}

	public function Set_Text($value){
		$this->Text = $value;
	}

	/**
	* Getter & Setter
	* @param Date
	*/
	public function Get_Date() {
		return $this->Date;
	}

	public function Set_Date($value){
		$this->Date = $value;
	}
}

?>