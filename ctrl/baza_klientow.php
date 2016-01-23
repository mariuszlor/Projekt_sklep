<?php 
$kliencip = array();
$kliencif = array();
$result = $DB->query("SELECT typ, nazwisko, imie, NIP, nazwa_firmy FROM klient") or DBdie($DB->error);
if($result) while($row = $result->fetch_assoc()) {
	if($row['typ']=='p') {
		if(!$row['nazwisko']) $row['nazwisko']='{Brak nazwiska}';
		if(!$row['imie']) $row['imie']='{Brak imienia}';
		$kliencip[] = $row;
	}
	else {
		if(!$row['nazwa_firmy']) $row['nazwa_firmy']='{Brak nazwy}';
		if(!$row['NIP']) $row['NIP']='{Brak NIP}';
		$kliencif[] = $row;
	}
}
?>