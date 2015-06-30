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
			$connectString = 'mysql:host='.$this->_host.';dbname='.$this->_dbName.'';
			$dbc = new PDO($connectString, $this->_user, $this->_pwd);
			var_dump($dbc);
			return $dbc;
		} 
		catch (Exception $e) {
			die($e->getMessage); //TODO logger les erreurs
		}
	}

	public function Insert(Imodel $entity){
		
		$tabName = strtolower(get_class($entity));
		try 
		{
			if(!$this->TableExist($tabName))
				throw new Exception("Aucune entité ne posséde le nom : ". $tabName ."", 1);
			echo "Je suis passé";	
			// Logique d'insertion de l'objet $entity dans la base
		} 
		catch (Exception $e) {
			die($e->getMessage); //TODO logger les erreurs
		}
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
	public function TableExist($tabName)
	{
		$exist = false;
		try 
		{
			$this->_mysqlObject->exec("SELECT * FROM ". $tabName ." WHERE 1");
			$exist = true;
		} 
		catch (Exception $e) 
		{
			return $exist;
		}
		return $exist;
	}
}

?>