<?php 
$dir = '/Projekt_sklep/';
function gen_hash($str) {
	$slt = '$2y$12$t0Nr3a1lYMepBmUspd4cH$';
	return substr(crypt($str, $slt), strlen($slt));
}

function validateLength($str, $min, $max) {
	if($min!=null AND strlen($str)<$min) return "Minimalna długość: $min znaków"; 
	if($max!=null AND strlen($str)>$max) return "Maksymalna długość: $max znaków";
	return 0;
}
function putMessage($str) {
	if(!isset($_SESSION['message'])) $_SESSION['message']='';
	else $_SESSION['message'].='<br />';
	$_SESSION['message'].=$str;
}
?>