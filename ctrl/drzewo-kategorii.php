<?php
// set global max_sp_recursion_depth = 255;

if(isset($_GET['kat'])) $gkat = $_GET['kat'];
if(isset($gkat) && is_numeric($gkat)) $kat = $gkat;
$kategorie = array();
$kategorie_płaskie = array();

$result = $DB->query("SELECT * FROM kategoria ORDER BY kategoria_id ASC") or DBdie($DB->error);
if($result) while($row = $result->fetch_assoc()) {
	$row['podkategorie']=array();
	if($row['id_nadrzednej']===null) $nadrzedna = &$kategorie;
	else $nadrzedna = &$kategorie_płaskie[$row['id_nadrzednej']]['podkategorie'];
	$nadrzedna[$row['kategoria_id']]=$row;
	$kategorie_płaskie[$row['kategoria_id']]=&$nadrzedna[$row['kategoria_id']];
}
?>