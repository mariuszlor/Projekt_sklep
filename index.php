<?php 
session_start();
include('Database.class.php');
$DB = Database::instance();
include('ctrl/functions.php');
?>
<?php 
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
		case 'logout':
			break;
		case 'logout-pracownik':
			break;
		default:
			header("Location: {$dir}glowna.html");
			exit;
	}
	$content = ob_get_contents();
	ob_end_clean(); 
}
include('view/view.php'); ?>