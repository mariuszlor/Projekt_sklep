<?php
// set global max_sp_recursion_depth = 255;
$kategorie = array();
$kategorie_płaskie = array();

function putKat($row) {
	global $kategorie;
	global $kategorie_płaskie;
	$row['podkategorie']=array();
	if($row['id_nadrzednej']===null) $nadrzedna = &$kategorie;
	else $nadrzedna = &$kategorie_płaskie[$row['id_nadrzednej']]['podkategorie'];
	$nadrzedna[$row['kategoria_id']]=$row;
	$kategorie_płaskie[$row['kategoria_id']]=&$nadrzedna[$row['kategoria_id']];
}


if(isset($_GET['kat'])) $gkat = $_GET['kat'];
if(isset($gkat) AND strpos($gkat, ',')) $gkat = substr($gkat, 0, strpos($gkat, ','));
if(isset($gkat) && is_numeric($gkat)) {
	$DB->real_query("call menu_drzewo_kat($gkat)") OR die($DB->error);
	$resultSets = array();
 	$i = 0;
	do {
		if ($res = $DB->store_result()) {
			$resultSets[$i++] = $res->fetch_all(MYSQLI_ASSOC);
			$res->free();
		} else if($DB->errno)
			putMessage($DB->error);
	} while ($DB->more_results() && $DB->next_result());
	for($l=count($resultSets)-1; $l>=0; $l--) {
		foreach($resultSets[$l] as $row) putKat($row);
	}
} else {
	$result = $DB->query("SELECT * FROM kategoria WHERE id_nadrzednej IS NULL ORDER BY kategoria_id ASC") or DBdie($DB->error);
	if($result) while($row = $result->fetch_assoc()) {
		putKat($row);
	}
}
?>