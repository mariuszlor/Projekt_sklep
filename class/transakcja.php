<?php
class transakcja {	
	static function status($s) {
		$statusy = array('u'=>'Utworzona', 'a'=>'Anulowana', 'p'=>'Potwierdzona', 'z'=>'Zapłacona',
			'w'=>'Wysłana', 'd'=>'Dostarczono towar');
		if(!isset($statusy[$s])) return 'Nieznany';
		else return $statusy[$s];
	}
}
?>