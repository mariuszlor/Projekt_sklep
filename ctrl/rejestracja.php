<?php 
if(isset($_POST['typkonta']) AND isset($_POST['login']) AND isset($_POST['password'])) {
	$typkonta = $DB->real_escape_string($_POST['typkonta']);
	$login = $DB->real_escape_string($_POST['login']);
	$password = $DB->real_escape_string(gen_hash($_POST['password']));
	
	$res = $DB->query("INSERT INTO klient SET typ='$typkonta', login='$login', haslo='$password'");
	if($res) {
		putMessage("Konto zostało utworzone");
	}
	else {
		putMessage("Nie można było utworzyć konta");
		DBdie($DB->error);
	}
}
?>