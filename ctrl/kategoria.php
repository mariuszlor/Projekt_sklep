<?php 
upr::wyrzucBezUprawnien(upr::kategoria);
if(isset($_POST['nowa_nazwa']) && isset($_POST['id_kat'])) {
	$idkat = $_POST['id_kat'];
	if(!is_numeric($idkat)) return;
	$nowanazwa = $DB->real_escape_string($_POST['nowa_nazwa']);
	$DB->query("UPDATE kategoria SET nazwa='$nowanazwa' WHERE kategoria_id=$idkat") or DBdie($DB->error);
}

if(isset($_POST['id_kat_do_usuniecia'])) {
	$idkatdel = $_POST['id_kat_do_usuniecia'];
	if(!is_numeric($idkatdel)) return;
	$DB->query("DELETE FROM kategoria WHERE kategoria_id=$idkatdel") or DBdie($DB->error);
}

if(isset($_POST['nowa_podkategoria']) && isset($_POST['id_kat'])) {
	$idkat = $_POST['id_kat'];
	if(!is_numeric($idkat)) return;
	$nowanazwa = $DB->real_escape_string($_POST['nowa_podkategoria']);
	$DB->query("INSERT INTO kategoria SET nazwa='$nowanazwa', id_nadrzednej=$idkat") or DBdie($DB->error);
}

if(isset($_POST['nowa_kategoria'])) {
	$nowanazwa = $DB->real_escape_string($_POST['nowa_kategoria']);
	$DB->query("INSERT INTO kategoria SET nazwa='$nowanazwa', id_nadrzednej=NULL") or DBdie($DB->error);
}

$podkategorie_edytowanej = array();
if(isset($_POST['id_kat'])) {
	$idkat = $_POST['id_kat'];
	if(!is_numeric($idkat)) $idkat=' IS NULL';
	else $idkat='='.$idkat;
	
	$result = $DB->query("SELECT kategoria_id, nazwa, id_nadrzednej FROM kategoria WHERE kategoria_id$idkat") or DBdie($DB->error);
	if($row=$result->fetch_assoc()) $kategoria_edytowana=$row;
}
if(!isset($idkat)) $idkat=' IS NULL';
$result = $DB->query("SELECT kategoria_id, nazwa FROM kategoria WHERE id_nadrzednej$idkat") or DBdie($DB->error);
while($row=$result->fetch_assoc()) $podkategorie_edytowanej[]=$row;
?>