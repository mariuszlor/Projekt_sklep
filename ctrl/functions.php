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

function DBdie($str) {
	putMessage($str);
	return false;
}

function sprawdz_uprawnienia() {
	$_SESSION['uprawnienia']=array();
	if(!isset($_SESSION['pracownik_id'])) return;
	$id = $_SESSION['pracownik_id'];
	if(!is_numeric($id)) return;
	$DB = Database::instance();
	$DB->query("SET @pracownikid=".$id);
	$result = $DB->query("SELECT uprawnienia FROM pracownik WHERE pracownik_id=@pracownikid") or die($DB->error);
	if($row = $result->fetch_assoc()) {
		$_SESSION['uprawnienia']=explode(';', $row['uprawnienia']);
	}
}

function pracownik_zalogowany() {
	return count($_SESSION['uprawnienia'])>0;
}

function gen_menu($kategorie) {
	$result = '';
	foreach($kategorie as $kategoria) {
		$maPodk = count($kategoria['podkategorie'])>0;
		$result.='<li'.($maPodk? 'class="active"' : '' ).
			"><a href=\"glowna.html?kat={$kategoria['kategoria_id']},{$kategoria['nazwa']}\">{$kategoria['nazwa']}</a>";
		if($maPodk) $result.='<ul>'.gen_menu($kategoria['podkategorie']).'</ul>';
		$result.='</li>';
	}
	return $result;
}

function build_sorter($key) {
	return function ($a, $b) use ($key) {
		return strnatcmp($a[$key], $b[$key]);
	};
}
?>