<?php
class koszyk {
	static function &produkty() {
		if(!isset($_SESSION['koszyk'])) $_SESSION['koszyk'] = array();
		return $_SESSION['koszyk'];
	}
	
	static function dodaj($produkt_id, $sztuk) {
		if(!is_numeric($sztuk)) return;
 		$k = &self::produkty();
		if(isset($k[$produkt_id])) $k[$produkt_id]+=$sztuk;
		else $k[$produkt_id] = $sztuk;
	}
	
	static function usun($produkt_id) {
		$k = &self::produkty();
		if(isset($k[$produkt_id])) unset($k[$produkt_id]);
	}
}
?>