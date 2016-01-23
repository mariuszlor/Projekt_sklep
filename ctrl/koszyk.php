<?php 
if(isset($_POST['produkt_id']) AND isset($_POST['sztuk'])) {
	koszyk::dodaj($_POST['produkt_id'], $_POST['sztuk']);
}

if(isset($_POST['produkt_id']) AND isset($_POST['ilosc']) AND isset($_POST['update'])) {
	if($_POST['ilosc']<=0) {
		putMessage("Liczba sztuk towaru musi być dodatnia. 
				Aby usunąć towar z koszyka, kliknij odpowiedni przycisk.");
	} else {
		koszyk::usun($_POST['produkt_id']);
		koszyk::dodaj($_POST['produkt_id'], $_POST['ilosc']);
	}
}

if(isset($_POST['produkt_id']) AND isset($_POST['delete'])) {
	koszyk::usun($_POST['produkt_id']);
}

$produkty = koszyk::produkty();
if(count($produkty)>0) {
	$produkty_q = '';
	foreach($produkty AS $id => $sztuk) {
		$produkty_q .= ', '.$id;
	}
	$produkty_q = substr($produkty_q, 2);
	$produkty_dane = array();
	$result = $DB->query("SELECT produkt_id, nazwa, cena, stan_magazyn FROM produkt WHERE produkt_id IN ($produkty_q) AND blokada=0") or DBdie($DB->error);
	if($result) while($row = $result->fetch_assoc()) {
		$row['sztuk'] = $produkty[$row['produkt_id']];
		if($row['sztuk']>$row['stan_magazyn']) {
			// sprawdzenie, czy jest wystarczająca liczba sztuk na magazynie
			$row['sztuk']=$row['stan_magazyn'];
			koszyk::usun($row['produkt_id']);
			koszyk::dodaj($row['produkt_id'], $row['sztuk']);
			putMessage("Dla produktu ".$row['nazwa']." nie posiadamy porządanej przez państwo liczby 
					produktów w magazynie. Ilość towaru w koszyku została ograniczona. 
					W celu zamówienia większej ilości towaru prosimy o kontakt.");
		}
		$produkty_dane[] = $row;		
	}
}
if(isset($_POST['tworz']) AND count($produkty_dane)>0) {
	$DB->autocommit(false);
	$suc = true;
	if(klient::$zalogowany) {
		$DB->query("INSERT INTO transakcja SET klient_id=".klient::$klient_id.", adres_wysylki='".klient::$dom_adr_wys."'") 
			OR ($suc=false) OR DBdie($DB->error);
	}
	else {
		$DB->query("INSERT INTO transakcja SET adres_wysylki='".klient::$dom_adr_wys."'") 
			OR ($suc=false) OR DBdie($DB->error);
	}
	if($DB->affected_rows!=1 OR !$ti=$DB->insert_id) $suc = false;
	if($suc) foreach($produkty_dane as $produkt_dane) {
		$DB->query("INSERT INTO transakcja_produkt_v SET 
				transakcja_id=$ti, 
				sztuk={$produkt_dane['sztuk']}, 
				produkt_edycja_id=ostatnia_produkt_edycja_id({$produkt_dane['produkt_id']})") OR ($suc=false) OR DBdie($DB->error);
	}
	if($suc) $DB->commit();
	else $DB->rollback();
	$DB->autocommit(true);
	if($suc) {
		header("Location: {$dir}transakcja.html?tr=".md5($ti));
		exit;
	}
}



?>