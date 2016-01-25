<h2>Panel zarządzania produktami</h2>
<?php 
if(count($kategorie_produkt_sorted)>0) {
	echo "<h3>Lista kategorii:</h3>";
	foreach($kategorie_produkt_sorted as $kat) {
		echo '<a href="produkt-edycja-lista.html?kategoria='.$kat['kategoria_id'].'">'.$kat['nazwa'].'</a><br />';
	}
}
else if(count($produkty)>0) {
	echo "<h3>Lista produktów:</h3>";
	foreach($produkty as $key => $value) {
		echo '<a href="produkt-edycja.html?produkt_id='.$key.'">'.$value.'</a><br />';
	}
}
?>