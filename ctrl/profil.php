<?php 
if(!klient::$zalogowany) upr::wyrzucStad();
if(klient::$typ=='p') {
	if(isset($_POST['imie']) AND isset($_POST['nazwisko']) AND isset($_POST['dom_adr_wys'])) {
		$imie 		= $DB->real_escape_string($_POST['imie']);
		$nazwisko 	= $DB->real_escape_string($_POST['nazwisko']);
		$dom_adr_wys= $DB->real_escape_string($_POST['dom_adr_wys']);
		$res = $DB->query("UPDATE klient SET
				imie='$imie',
				nazwisko='$nazwisko',
				dom_adr_wys='$dom_adr_wys'				
				WHERE klient_id=".klient::$klient_id);
		if($res) {
			putMessage("Dane zaktualizowane pomyślnie");
			klient::wyciagnij_dane();
		}
		else DBdie($DB->error);
	}
}
if(klient::$typ=='f') {
	if(isset($_POST['nazwa_firmy']) AND isset($_POST['NIP']) AND isset($_POST['dom_adr_wys'])) {
		$nazwa_firmy = $DB->real_escape_string($_POST['nazwa_firmy']);
		$NIP 		 = $DB->real_escape_string($_POST['NIP']);
		$dom_adr_wys = $DB->real_escape_string($_POST['dom_adr_wys']);
		$res = $DB->query("UPDATE klient SET
				nazwa_firmy='$nazwa_firmy',
				NIP='$NIP',
				dom_adr_wys='$dom_adr_wys'
				WHERE klient_id=".klient::$klient_id);
		if($res) {
			putMessage("Dane zaktualizowane pomyślnie");
			klient::wyciagnij_dane();
		}
		else DBdie($DB->error);
	}
}
if(isset($_POST['password']) AND isset($_POST['newPassword']) AND isset($_POST['newPassword2'])) {
	if($_POST['newPassword']==$_POST['newPassword2']) {
		$password = $DB->real_escape_string(gen_hash($_POST['password']));
		$newPassword = $DB->real_escape_string(gen_hash($_POST['newPassword']));
		$res = $DB->query("UPDATE klient SET
				haslo='$newPassword'
				WHERE klient_id=".klient::$klient_id." AND haslo='$password'");
		if($res) {
			if($DB->affected_rows) {
				putMessage("Hasło zostało zmienione");
				klient::wyciagnij_dane();
			}
			else putMessage("Hasło nie zostało zmienione. Czy poprawnie podałeś obecne hasło?");
		}
		else DBdie($DB->error);
	}
	else {
		putMessage("Hasła muszą być jednakowe");
	}
}
?>