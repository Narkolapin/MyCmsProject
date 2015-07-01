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
		$tabName = str_replace("model", "", strtolower(get_class($entity)));		
		$stringParam = "(";															
		$stringValue = "(";															
		
		try {
			if(!$this->TableExist($this->_dbName, $tabName))
				throw new Exception("Aucune entité ne posséde le nom : ". $tabName ."", 1);
			// Création e la requete
			foreach ($entity->GetObjectProperty() as $key => $value) {
				$stringParam = $stringParam . "" . strtolower($key) .",";
				$stringValue = $stringValue . "\"" . $value . "\",";
			}
			$stringParam = substr($stringParam, 0, -1).")";
			$stringValue = substr($stringValue, 0, -1).")";
			$stringRequest = "INSERT INTO ".$tabName." ".$stringParam." VALUES ".$stringValue."";

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
	* @param null
	* @return array
	*/
	public function Select(){
		throw new Exception("Methode non implémentée", 1);
	}

	/**
	* Vérifis qu'une table existe bien
	* @param string nom de table à tester
	* @return bool resprésentant l'existance de la table
	*/
	public function TableExist($dbName, $tabName){
		$exist = false;
		try 
		{
			$stringRequest = "SELECT * FROM information_schema.tables WHERE table_schema = '".$dbName."' AND table_name = '". $tabName ."' LIMIT 1";
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