<?php
$kategorie = array();

$result = $DB->query("SELECT * FROM kategoria ORDER BY kategoria_id") or DBdie($DB->error);
if($result) while($row = $result->fetch_assoc()) {
	$row['podkategorie']=array();
	if($row['id_nadrzednej']===null) $nadrzedna = &$kategorie;
	else $nadrzedna = &$kategorie[$row['id_nadrzednej']]['podkategorie'];
	$nadrzedna[$row['kategoria_id']]=$row;
}
?>