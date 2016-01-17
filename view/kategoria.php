<h2>Panel zarządzania kategoriami</h2>
<?php if(isset($kategoria_edytowana)) { ?>
	Kategoria: <?php echo $kategoria_edytowana['nazwa']; ?><br />

<form class="formularz" action="kategoria.html" method="post" >
  <h1>Edycja strony</h1>
  <input type="hidden" name="id_kat" value="<?php echo $kategoria_edytowana['kategoria_id']; ?>" />
  <ul>
  <li>
  	<label for="nowa_nazwa">Zmień nazwę kategorii na</label>
  	<input type="text" name="nowa_nazwa" value="<?php echo $kategoria_edytowana['nazwa']; ?>" >
  </li>
  <li>
  	<input type="submit" value="Zmień nazwę">
  </li>
  </ul>
</form>

<?php if(count($podkategorie_edytowanej)==0) { ?>
<form class="formularz" action="kategoria.html" method="post" >
  <h1>Usuń kategorię</h1>
  <input type="hidden" name="id_kat_do_usuniecia" value="<?php echo $kategoria_edytowana['kategoria_id']; ?>" />
  <?php if(is_numeric($kategoria_edytowana['id_nadrzednej'])) { ?>
	<input type="hidden" name="id_kat" value="<?php echo $kategoria_edytowana['id_nadrzednej']; ?>" />
  <?php } ?>
  <ul><li>
  <input type="submit" value="Usuń kategorię">
  </li></ul>
</form>
<?php } ?>

<form class="formularz" action="kategoria.html" method="post" >
  <h1>Dodaj nową podkategorię:</h1>
  <input type="hidden" name="id_kat" value="<?php echo $kategoria_edytowana['kategoria_id']; ?>" />
  <ul>
  	<li>
  	  <label for="nowa_podkategoria">Nazwa nowej podkategorii</label>
  	  <input type="text" name="nowa_podkategoria" >
  	</li>
  	<li>
  	  <input type="submit" value="Dodaj podkategorię">
  	</li>
  </ul>
</form>
	<?php if(is_numeric($kategoria_edytowana['id_nadrzednej'])) { ?>
<form class="formularz" action="kategoria.html" method="post" >
	<input type="hidden" name="id_kat" value="<?php echo $kategoria_edytowana['id_nadrzednej']; ?>" />
	<ul><li>
	<input type="submit" value="Kategoria nadrzędna" />
	</li></ul>
</form>
	<?php } else { ?>
<form class="formularz" action="kategoria.html" method="post" >
	<ul><li>
	<input type="submit" value="Kategorie główne" />
	</li></ul>
</form>
	<?php } ?>
<?php } else { ?>
<form class="formularz" action="kategoria.html" method="post" >
  <h1>Dodaj nową podkategorię:</h1>
  <ul>
  	<li>
  	  <label for="nowa_podkategoria">Nazwa nowej podkategorii</label>
  	  <input type="text" name="nowa_kategoria" >
  	</li>
  	<li>
  	  <input type="submit" value="Dodaj podkategorię">
  	</li>
  </ul> 
</form>

<?php } ?>

<?php if(count($podkategorie_edytowanej)>0) { ?>
<form class="formularz blisko" action="kategoria.html" method="post" >
<h1>Przejdź do jednej z kategorii</h1>
</form>
<?php } ?>

<?php foreach($podkategorie_edytowanej AS $kat) { ?>
<form class="formularz blisko" action="kategoria.html" method="post" >
<input type="hidden" name="id_kat" value="<?php echo $kat['kategoria_id']; ?>" />
<ul>
  <li>
	<input type="submit" value="<?php echo $kat['nazwa']; ?>" />
  </li>
</ul>
</form>
<?php } ?>