<?php 
$login = $_POST['login'];
$password = gen_hash($_POST['password']);


$login = $DB->real_escape_string($login);
$password = $DB->real_escape_string($password);

$result = $DB->query("SELECT pracownik_id, uprawnienia FROM pracownik WHERE login='$login' AND haslo='$password'") or die($DB->error);
if($result->num_rows) {
	$row = $result->fetch_row();
	$_SESSION['pracownik_id']=$row[0];
	putMessage('Zostałeś zalogowany');
}
else putMessage('Niewłaściwy login lub hasło');
?>