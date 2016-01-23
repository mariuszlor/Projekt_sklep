<?php 
if(isset($produkty)) {
	if(count($produkty)==0) echo '<h2>Brak produktów w tej kategorii<h2>';
	else {
		$kategoria = $kategorie_płaskie[$gkat];
		echo '<h2>Produkty w kategorii <i>'.$kategoria['nazwa'].'</i><h2>';
		echo '<ul>';
		foreach($produkty as $produkt) {
			echo "<li><a href=\"produkt.html?".
				"kat={$kategoria['kategoria_id']},{$kategoria['nazwa']}".
				"&produkt={$produkt['produkt_id']},{$produkt['nazwa']}\">{$produkt['nazwa']}</a></li>";
		}
		echo '</ul>';
	}
}
if(isset($produkt_wysw)) {
	$htitle = $produkt_wysw['nazwa'];
	echo '<h2>'.$produkt_wysw['nazwa'].'</h2>';
	echo '<h3>Cena: '.$produkt_wysw['cena'].'</h2>';
	echo $produkt_wysw['opis'];
	echo '
<form class="formularz" action="koszyk.html" method="post" >
<input type="hidden" name="produkt_id" value="'.$produkt_wysw['produkt_id'].'" />
<h1>Dodaj produkt do koszyka</h1>
<ul>
<li>
	<label for="sztuk">Ilość sztuk</label>
	<input type="number" value="1" name="sztuk" />
</li>
<li>
	<input type="submit" value="Dodaj" />		
</li>
</ul>
</form>	
';
}

?>
