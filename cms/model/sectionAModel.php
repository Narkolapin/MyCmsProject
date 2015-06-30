<?php

require_once("/cms/model/IModel.php");	

class sectionAModel extends IModel
{
	private $Text;
	private $Date;

	public function sectionAModel(array $post)
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

		$this->Date =date("Y-m-d H:i:s");
	}
}
?>