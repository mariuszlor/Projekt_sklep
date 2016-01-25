<?php
class database extends mysqli{
	static $THIS; //instancja singletona

	private $host 	= 'localhost';
	private $login 	= 'interfejs';
	private $pass 	= '3ctA3CEqTpWjNCxQ';
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
}
?>