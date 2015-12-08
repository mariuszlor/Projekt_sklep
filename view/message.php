<?php
if(isset($_SESSION['message'])) {
	echo "<div id=\"message\">$_SESSION[message]</div>";
	unset($_SESSION['message']);
}
?>