<?php 
if(isset($_GET['tr'])) {
	$hash = $DB->real_escape_string($_GET['tr']);
	$result = $DB->query("SELECT * FROM transakcja WHERE MD5(transakcja_id)='$hash' LIMIT 1") OR DBdie($DB->error);
	if($result AND $row=$result->fetch_assoc()) {
		$transakcja = $row;
	}
}
if(isset($transakcja)) {
	$towary_kupione = array();
	$resultSet = array();
	$result = $DB->query("SELECT produkt_edycja_id, sztuk FROM transakcja_produkt_v WHERE transakcja_id='{$transakcja['transakcja_id']}'") OR DBdie($DB->error);
	if($result) while($row=$result->fetch_assoc()) {
		$resultSet[]=$row;	
	}
	foreach($resultSet as $row) {
		$DB->real_query("CALL produkt_hist({$row['produkt_edycja_id']})") OR DBdie($DB->error);
		if($result = $DB->store_result()) {
			$row2 = $result->fetch_assoc();
			$row2['sztuk']=$row['sztuk'];
			$towary_kupione[]=$row2;
			$result->free();
			//uleep(100*1000);
		}
		while ($DB->more_results() && $DB->next_result()) print_r($res = $DB->store_result());
	}
}
?>