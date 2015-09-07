<?php
require_once("/cms/model/IModel.php");
/**
* 
*/
class MySQLTools
{
	private $_host;
	private $_user;
	private $_pwd;
	private $_dbName;
	private $_mysqlObject;

	public function MySQLTools($host, $user, $pwd, $dbName){
		$this->_host = $host;
		$this->_user = $user;
		$this->_pwd = $pwd;
		$this->_dbName = $dbName;
		$this->_mysqlObject = $this->MySqlConnect();
	}

	/**
	* Connexion à la base de données
	* @param null
	* @return Object PDO
	*/
	private function MySqlConnect(){
		try 
		{
			$connectString = 'mysql:host='.$this->_host.';dbname='.$this->_dbName.';charset=utf8';
			$dbc = new PDO($connectString, $this->_user, $this->_pwd);
			$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $dbc;
		} 
		catch (Exception $e) {
			die($e->getMessage); //TODO logger les erreurs
		}
	}

	/**
	* Envois d'une requete INSERT a la base de donnée MySQL
	* @param IModel $entity 
	* @return bool $success
	*/
	public function Insert(IModel $entity){
		
		$success = false;
		$_tabName = str_replace("model", "", strtolower(get_class($entity)));		
		$stringParam = "(";															
		$stringValue = "(";															
		
		try {
			if(!$this->TableExist($this->_dbName, $_tabName))
				throw new Exception("Aucune entité ne posséde le nom : ". $_tabName ."", 1);
			// Création e la requete
			foreach ($entity->GetObjectProperty() as $key => $value) {
				$stringParam = $stringParam . "" . strtolower($key) .",";
				$stringValue = $stringValue . "\"" . $value . "\",";
			}
			$stringParam = substr($stringParam, 0, -1).")";
			$stringValue = substr($stringValue, 0, -1).")";
			$stringRequest = "INSERT INTO ".$_tabName." ".$stringParam." VALUES ".$stringValue."";

			// Envois de la requete
			$launch = $this->_mysqlObject->query($stringRequest);
			$success = true;
		} 
		catch (Exception $e){
			echo 'Erreur MySQL : ';
			echo ''.$e->getMessage().' '.$e->getCode().''; //TODO logger les erreurs
		}
		return $success;
	}

	/**
	* Génere une requette Select dans une base Mysql
	* @param array $fieldSelect : paramétres optionnel pour la recherche d'une ligne
	* @param array $condition : parametres conditionnels
	* @param IModel $entity : objet de l'entité qui sera
	* @return array
	*/
	public function Select(IModel $entity, array $fieldSelect = null, array $condition = null){
		try 
		{
 			$result = array();
			$_fieldName = "";
			$_condition = "";
			$_tableName = substr(strtolower(get_class($entity)),0, -5);
			
			// Test _tableName
			if(!$this->TableExist($this->_dbName, $_tableName))
				throw new Exception("Error Processing Request SELECT, invalide _tableName", 1);
				
			// Champs à récupérer
			if(isset($fieldSelect)){
				foreach ($fieldSelect as $value) {
					$_fieldName = $_fieldName." ".$value.",";
				}
				
				$_fieldName = substr($_fieldName, 0, -1)." ";
			}
			else {
				$_fieldName = "*";
			}

			// elements conditionnel
			if(isset($condition)) {
				foreach ($condition as $key => $value) {
					$_condition = $_condition." ".$key."=".$value.",";
				}

				$_condition = substr($_condition, 0, -1);	
			}				
			else {
				$_condition = "1";
			}

			// Envoi de la requete
			$stringRequest = "SELECT ".$_fieldName." FROM ". $_tableName ." WHERE ".$_condition;
			$launch = $this->_mysqlObject->prepare($stringRequest);
			$launch->setFetchMode(PDO::FETCH_CLASS, get_class($entity));
			$launch->execute();
			$result = $launch->fetchAll();
			$launch->closeCursor();
			return $result;
		} 
		catch (Exception $e) {
			var_dump($e);
		}

	}

	/**
	* Vérifis qu'une table existe bien
	* @param string nom de table à tester
	* @return bool resprésentant l'existance de la table
	*/
	private function TableExist($dbName, $tableName){
		$exist = false;
		try 
		{
			$stringRequest = "SELECT * FROM information_schema.tables WHERE table_schema = '".$dbName."' AND table_name = '". $tableName ."' LIMIT 1;";
			$launch = $this->_mysqlObject->query($stringRequest);
			$responce = $launch->fetch(PDO::FETCH_ASSOC);
			if($responce != false)
				$exist = true;
			$launch->closeCursor();
		} 
		catch (Exception $e) 
		{
			echo $e->getMessage();
			return $exist;
		}
		return $exist;
	}
}

?>