<?php
class BaseSql{

	private $table;
	private $columns;
	private $pdo;

	public function __construct() {
		try {
			$this->pdo = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME.";port=".DBPORT, DBUSER, DBPWD);
		} catch (Exception $e) {
			print "erreur".$e->getMessage()."<br/>";
			die();
		}		
		$this->table = strtolower(get_called_class());
	}

	public function setColumns () {
		$columnsExcluded = get_class_vars(get_class());
		$this->columns = array_diff_key(get_object_vars($this), $columnsExcluded);
	}

	public function save(){
		$this->setColumns();
		echo '<pre>';
		print_r($this);

		if ($this->id) {
			// $res = $this->pdo->query('SELECT * FROM user', PDO::FETCH_ASSOC);
			// $donnees = $res->fetch();
			// print_r($donnees);
			$query = $this->pdo->prepare("INSERT INTO ".$this->table." (".implode(',', array_keys($this->columns)).") 
			VALUES (:".implode(',:', array_keys($this->columns)).");");
			$query->execute($this->columns);
			$nbLignes = $query->rowCount();
			echo $nbLignes;
		} else {
		}
	}

}