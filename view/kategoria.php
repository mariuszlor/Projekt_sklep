<h2>Panel zarządzania kategoriami</h2>
<?php if(isset($kategoria_edytowana)) { ?>
	Kategoria: <?php echo $kategoria_edytowana['nazwa']; ?><br />
<form action="kategoria.html" method="post" >
  <b>Zmień nazwę kategorii na:</b>
  <input type="text" name="nowa_nazwa" value="<?php echo $kategoria_edytowana['nazwa']; ?>" >
  <input type="hidden" name="id_kat" value="<?php echo $kategoria_edytowana['kategoria_id']; ?>" />
  <input type="submit" value="Zmień nazwę"><br>
</form>

<?php if(count($podkategorie_edytowanej)==0) { ?>
<form action="kategoria.html" method="post" >
  <b>Usuń kategorię</b>
  <input type="hidden" name="id_kat_do_usuniecia" value="<?php echo $kategoria_edytowana['kategoria_id']; ?>" />
  <?php if(is_numeric($kategoria_edytowana['id_nadrzednej'])) { ?>
	<input type="hidden" name="id_kat" value="<?php echo $kategoria_edytowana['id_nadrzednej']; ?>" />
  <?php } ?>
  <input type="submit" value="Usuń kategorię">
</form>
<?php } ?>

<form action="kategoria.html" method="post" >
  <b>Dodaj nową podkategorię:</b>
  <input type="text" name="nowa_podkategoria" >
  <input type="hidden" name="id_kat" value="<?php echo $kategoria_edytowana['kategoria_id']; ?>" />
  <input type="submit" value="Dodaj podkategorię"><br>
</form>
	<?php if(is_numeric($kategoria_edytowana['id_nadrzednej'])) { ?>
		<form action="kategoria.html" method="post" >
		<input type="hidden" name="id_kat" value="<?php echo $kategoria_edytowana['id_nadrzednej']; ?>" />
		<input type="submit" value="Kategoria nadrzędna" />
		</form>
	<?php } else { ?>
		<form action="kategoria.html" method="post" >
		<input type="submit" value="Kategorie główne" />
		</form>
	<?php } ?>
<?php } else { ?>
<form action="kategoria.html" method="post" >
  <b>Dodaj nową kategorię:</b>
  <input type="text" name="nowa_kategoria" >
  <input type="submit" value="Dodaj kategorię"><br>
</form>
<?php } ?>


<?php foreach($podkategorie_edytowanej AS $kat) { ?>
	<form action="kategoria.html" method="post" >
	<input type="hidden" name="id_kat" value="<?php echo $kat['kategoria_id']; ?>" />
	<input type="submit" value="<?php echo $kat['nazwa']; ?>" />
	</form>
<?php } ?>