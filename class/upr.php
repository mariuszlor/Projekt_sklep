<?php
class upr {
	const pracownik	= 'pracownik';
	const kategoria = 'kategoria';
	const produkt	= 'produkt';
	const wysylka = 'wysylka';
	const klient = 'klient';
	const raport = 'raport';
	
	static function maUprawnienia($upr) {
		return isset($_SESSION['uprawnienia']) && in_array($upr, $_SESSION['uprawnienia']);
	}
	
	static function wyrzucBezUprawnien($upr) {
		if(self::maUprawnienia($upr)) return;
		putMessage('Nie masz uprawnień do przeglądania tej zawartości');
		header("Location: {$dir}glowna.html");
		exit;
	}
	static function wyrzucStad() {
		putMessage('Nie masz uprawnień do przeglądania tej zawartości');
		header("Location: {$dir}glowna.html");
		exit;
	}
}
?>