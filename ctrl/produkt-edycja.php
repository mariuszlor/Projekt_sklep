<?php 
upr::wyrzucBezUprawnien(upr::produkt);

$kategorie_produkt = array();
$kategorie_produkt_sorted = array();

$result = $DB->query("SELECT * FROM kategoria ORDER BY kategoria_id ASC") or DBdie($DB->error);
if($result) while($row = $result->fetch_assoc()) {
	$row['podkategorie']=array();
	if($row['id_nadrzednej']===null);
	else {
		$row['nazwa'] = $kategorie_produkt[$row['id_nadrzednej']]['nazwa'].' > '.$row['nazwa'];
	}
	$kategorie_produkt[$row['kategoria_id']]=$row;
}

foreach($kategorie_produkt AS $kategoria_produkt) $kategorie_produkt_sorted[]=$kategoria_produkt;
usort($kategorie_produkt_sorted, build_sorter('nazwa'));

if(isset($_POST['produkt_id']))	$produkt_id	= $_POST['produkt_id'];
if(isset($_POST['nazwa'])) 		$nazwa		= $DB->real_escape_string($_POST['nazwa']);
if(isset($_POST['opis'])) 		$opis 		= $DB->real_escape_string($_POST['opis']);
if(isset($_POST['id_kat'])) 	$id_kat 	= $_POST['id_kat'];
if(isset($_POST['cena'])) 		$cena 		= $DB->real_escape_string($_POST['cena']);
if(isset($_POST['nieblokuj'])) 	
	$nieblokuj 	= true&&$_POST['nieblokuj'];
else $nieblokuj = false;
$blokada = $nieblokuj?0:1;
if(isset($_POST['stan_magazyn'])) $stan_magazyn = $_POST['stan_magazyn'];

if(isset($nazwa) AND isset($opis) AND isset($id_kat) AND isset($cena)) {
	if($cena<=0) putMessage("Cena musi być dodatnia (nie może być zerowa)");
	else if(strlen($nazwa)<3) putMessage("Nazwa produktu nie może być krótsza, niż 3 znaki");
	else if(strlen($nazwa)>50) putMessage("Nazwa produktu nie może być dłuższa, niż 50 znaków");
	else if(strlen($opis)<5) putMessage("Wprowadź opis produktu");
	else if(!isset($kategorie_produkt[$id_kat])) putMessage("Kategoria, do której próbowano dodać produkt, nie istnieje");
	else {
		if(isset($produkt_id) AND is_numeric($produkt_id)) {
			$res = $DB->query("UPDATE produkt SET 
					nazwa='$nazwa',
					kategoria_id='$id_kat',
					opis='$opis',
					stan_magazyn='$stan_magazyn',
					cena='$cena',
					blokada=$blokada WHERE produkt_id=$produkt_id");
			if($res) {
				putMessage("Dane zaktualizowane pomyślnie");
			}
			else DBdie($DB->error);
		}
		else {
			$res = $DB->query("INSERT INTO produkt SET
					nazwa='$nazwa',
					kategoria_id='$id_kat',
					opis='$opis',
					stan_magazyn='$stan_magazyn',
					cena='$cena',
					blokada=$blokada") or DBdie($DB->error);
			if($res) {
				putMessage("Pomyślnie dodano nowy produkt");
				$produkt_id = $DB->insert_id;
			}
		}
	}
}
else if(isset($_GET['produkt_id'])) {
	if(is_numeric($_GET['produkt_id'])) {
		$result = $DB->query("SELECT * FROM produkt WHERE produkt_id=".$_GET['produkt_id']) or DBdie($DB->error);
		if($result AND $row = $result->fetch_assoc()) {
			$produkt_id	= $row['produkt_id'];
			$nazwa 		= $row['nazwa'];
			$opis 		= $row['opis'];
			$id_kat 	= $row['kategoria_id'];
			$cena 		= $row['cena'];
			$nieblokuj 	= !$row['blokada'];
			$stan_magazyn = $row['stan_magazyn'];
		}
	}
}
?>