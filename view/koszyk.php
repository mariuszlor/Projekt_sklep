<h1>Twój koszyk</h1>
<?php 
if(isset($produkty_dane) AND count($produkty_dane)>0) {
echo "<h2>Twój koszyk zawiera:</h2> ";
foreach($produkty_dane AS $produkt_dane) { ?>	
<form class="formularz blisko" action="koszyk.html" method="post" >
<input type="hidden" name="produkt_id" value="<?php echo $produkt_dane['produkt_id']; ?>" />
<h1>Produkt: <?php echo $produkt_dane['nazwa']; ?></h1>
<ul>
<li>
<label for="ilosc">Ilość sztuk</label>
<input type="number" name="ilosc" value="<?php echo $produkt_dane['sztuk']; ?>" />
</li>
<li>
<input type="submit" name="delete" value="Usuń produkt z koszyka" >
<input type="submit" name="update" value="Zapisz" >
</li>
</ul>
</form>
<?php } ?>
<h2>Zakup towary, które masz w koszyku</h2>
<h3>Zostaniesz przekierowany na stronę z podsumowaniem transakcji przed jej zatwierdzeniem</h3>
<form class="formularz" action="transakcja.html" method="post" >
<ul>
<li>
<input type="submit" name="tworz" value="Kupuję" />
</li>
</ul>
</form>
<?php } else { ?>
<h3>Twój koszyk jest pusty</h3>
<?php } ?>