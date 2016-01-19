<?php 
if(isset($_GET['produkt'])) $gprod = $_GET['produkt'];
if(isset($gprod) AND strpos($gprod, ',')) $gprod = substr($gprod, 0, strpos($gprod, ','));
if(isset($gprod) AND is_numeric($gprod)) {
	$result = $DB->query("SELECT * FROM produkt WHERE produkt_id=$gprod") or DBdie($DB->error);
	if($result) if($row = $result->fetch_assoc()) {
		$produkt_wysw = $row;
		$htitle = $produkt_wysw['nazwa'];
	}
}

else if(isset($gkat) && is_numeric($gkat)) {
	$produkty = array();
	echo '<pre>';
	$DB->real_query("call produkt_by_kategoria($gkat)") OR die($DB->error);
	do {
		if ($res = $DB->store_result()) {
			$produkty = $res->fetch_all(MYSQLI_ASSOC);
			$res->free();
		} else if($DB->errno)
		echo $DB->error;
	} while ($DB->more_results() && $DB->next_result());
	echo '</pre>';
}
?>