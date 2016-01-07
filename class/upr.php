<?php
class upr {
	const pracownik	= 'pracownik';
	const kategoria	= 'kategoria';
	const produkt	= 'produkt';
	const wysylka	= 'wysylka';
	const raport	= 'raport';
	const klient	= 'klient';
	
	static function maUprawnienia($upr) {
		return isset($_SESSION['uprawnienia']) && in_array($upr, $_SESSION['uprawnienia']);
	}
	
	static function wyrzucBezUprawnien($upr) {
		if(self::maUprawnienia($upr)) return;
		putMessage('Nie masz uprawnień do przeglądania tej zawartości');
		header("Location: {$dir}glowna.html");
		exit;
	}
}
?>