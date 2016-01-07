<?php 
session_start();
include('class/database.php');
include('class/upr.php');
$DB = database::instance();
include('ctrl/functions.php');
sprawdz_uprawnienia();
//*
$DB->query("DELETE FROM kategoria");
echo '<pre>';
random_cats(3);
exit;
/*/
if(isset($_GET['site']) AND $_GET['site']!='' AND $_GET['site']!='index') {
	ob_start();
	switch($_GET['site']) {
		case 'logout': 
			session_destroy();
			header("Location: {$dir}glowna.html");
			break;
		case 'glowna':
			$htitle = 'Home - ';
			include('view/glowna.php'); 
			break;
		case 'login':
			if(isset($_POST['login']) AND isset($_POST['password'])) include('ctrl/login.php');
			$htitle = 'Klient - logowanie';
			include('view/logowanie.php'); 
			break;
		case 'login-pracownik':
			if(isset($_POST['login']) AND isset($_POST['password'])) include('ctrl/login-pracownik.php');
			$htitle = 'Pracownik - logowanie';
			include('view/logowanie_pracownik.php'); 
			break;
		case 'kategoria':
			include('ctrl/kategoria.php');
			$htitle = 'Zarządzanie kategoriami';
			include('view/kategoria.php'); 
			break;
		default:
			header("Location: {$dir}glowna.html");
			exit;
	}
	$content = ob_get_contents();
	ob_end_clean(); 
}
include('ctrl/drzewo-kategorii.php');
echo '<pre>'; print_r($kategorie); exit;
include('view/view.php'); 
/**/
?>