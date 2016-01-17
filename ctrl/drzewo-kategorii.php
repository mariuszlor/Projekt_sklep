<?php
// set global max_sp_recursion_depth = 255;

/*
 echo '<pre>';
 $DB->real_query("call testp()") OR die($DB->error);
 do {
 if ($res = $DB->store_result()) {
 printf("---\n");
 var_dump($res->fetch_all());
 $res->free();
 } else {
 if ($DB->errno) {
 echo "Store failed: (" . $DB->errno . ") " . $DB->error;
 }
 }
 } while ($DB->more_results() && $DB->next_result());
 echo "Koniec wynikow";
 exit;
 */

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