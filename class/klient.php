<?php
class klient {
	static $zalogowany;
	static $login;
	static $klient_id;
	static $typ;
	static $imie;
	static $nazwisko;
	static $NIP;
	static $nazwa_firmy;
	static $dom_adr_wys;
	
	static function wyciagnij_dane() {
		$DB = Database::instance();
		if(!isset($_SESSION['klient_id']) OR !is_numeric($_SESSION['klient_id'])) {
			self::$zalogowany = false;
			return;
		}
		$result = $DB->query("SELECT * FROM klient WHERE klient_id=".$_SESSION['klient_id']);
		if($result) {
			if($row = $result->fetch_assoc()) {
				self::$klient_id 	= $row['klient_id'];
				self::$login 		= $row['login'];
				self::$typ 			= $row['typ'];
				self::$imie 		= $row['imie'];
				self::$nazwisko 	= $row['nazwisko'];
				self::$NIP 			= $row['NIP'];
				self::$nazwa_firmy 	= $row['nazwa_firmy'];
				self::$dom_adr_wys	= $row['dom_adr_wys'];
				self::$zalogowany 	= true;
			}
			else session_destroy();
		} 
		else DBdie($DB->error);		
	}
}
klient::wyciagnij_dane();
?>