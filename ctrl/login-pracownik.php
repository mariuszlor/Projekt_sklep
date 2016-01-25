<?php 
$login = $DB->real_escape_string($_POST['login']);
$password = $DB->real_escape_string(gen_hash($_POST['password']));

$result = $DB->query("SELECT pracownik_id FROM pracownik WHERE login='$login' AND haslo='$password'") or DBdie($DB->error);
if($result && $row = $result->fetch_row()) {
	$_SESSION['pracownik_id']=$row[0];
	if(isset($_SESSION['klient_id'])) unset($_SESSION['klient_id']);
	putMessage('Zostałeś zalogowany');
	header("Location: {$dir}glowna.html");
	exit;
}
else putMessage('Niewłaściwy login lub hasło');
?>