<?php
class database extends mysqli{
	static $THIS; //instancja singletona

	private $host 	= 'localhost';
	private $login 	= 'root';
	private $pass 	= '';
	private $db 	= 'projekt_bazy_sklep';
	
	private function __construct(){
		parent::__construct($this->host, $this->login, $this->pass, $this->db);
	}
	
	static function instance(){
		if(empty(self::$THIS) OR !self::$THIS->ping()) {
			self::$THIS = new database();
			self::$THIS->query('SET NAMES \'utf8\'');
		}
		return self::$THIS;
	}
	
	/*
	function calc_found_rows(){
		$result = $this->query("SELECT FOUND_ROWS()");
		if($result->num_rows)
		{
			$row = $result->fetch_row();
			return $row[0];
		}
		return 0;
	}
	
	function begin(){
		$this->autocommit(false);
	}
	
	function rollback(){
		parent::rollback();
		$this->autocommit(true);
	}
	
	function commit(){
		parent::commit();
		$this->autocommit(true);
	}
	
	function resultNumRows($query){
		$result = $this->query($query) or die('Nie można pobrać danych - Database::resultNumRows');
		intval($result->num_rows);
	}
	*/
}


?>