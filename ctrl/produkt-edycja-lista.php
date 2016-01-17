<?php 
upr::wyrzucBezUprawnien(upr::produkt);

$kategorie_produkt = array();
$kategorie_produkt_sorted = array();
$produkty = array();

if(!isset($_GET['kategoria'])) {
	$result = $DB->query("SELECT k.*, COUNT(p.produkt_id) AS produktow FROM kategoria k LEFT JOIN produkt p USING(kategoria_id) GROUP BY kategoria_id ORDER BY kategoria_id ASC") or DBdie($DB->error);
	if($result) while($row = $result->fetch_assoc()) {
		$row['podkategorie']=array();
		if($row['id_nadrzednej']===null);
		else {
			$row['nazwa'] = $kategorie_produkt[$row['id_nadrzednej']]['nazwa'].' > '.$row['nazwa'];
		}
		$kategorie_produkt[$row['kategoria_id']]=$row;
	}

	foreach($kategorie_produkt AS $kategoria_produkt) 
		if($kategoria_produkt['produktow']>0) $kategorie_produkt_sorted[]=$kategoria_produkt;
	usort($kategorie_produkt_sorted, build_sorter('nazwa'));
}
else if(is_numeric($_GET['kategoria'])){
	$id_kat = $_GET['kategoria'];
	$result = $DB->query("SELECT produkt_id, nazwa FROM produkt WHERE kategoria_id=".$id_kat) or DBdie($DB->error);
	if($result) while($row = $result->fetch_assoc()) {
		$produkty[$row['produkt_id']]=$row['nazwa'];
	}
}
?>