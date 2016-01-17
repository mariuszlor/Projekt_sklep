<h2>Panel zarządzania produktami</h2>
<form class="formularz" action="produkt-edycja.html" method="post" >
 <?php if(isset($produkt_id)) echo '<input type="hidden" name="produkt_id" value="'.$produkt_id.'" /><h1>Edycja produktu</h1>';
 else echo '<h1>Dodaj nowy produkt</h1>'; ?>  
  <ul>
  <li>
  	<label for="nazwa">Nowa nazwa produktu</label>
  	<input type="text" name="nazwa" value="<?php if(isset($nazwa)) echo $nazwa; ?>" >
  </li>
  <li>
  	<label for="opis">Opis produktu</label>
    <textarea name="opis" class="ckeditor" ><?php if(isset($opis)) echo $opis; ?></textarea>
  </li>
  <li>
    <select name="id_kat">
     <?php foreach($kategorie_produkt_sorted AS $kategoria) {
     	$selected = (isset($id_kat) && $id_kat==$kategoria['kategoria_id']) ? 'selected ':'';
     	echo '<option value="'.$kategoria['kategoria_id'].'" '.$selected.'>'.$kategoria['nazwa'].'</option>'; } ?>
    </select>
  </li>
  <li>
    <label for="cena">Cena produktu</label>
    <input type="text" name= "cena" onkeyup="nformat(this)" onchange="priceformat(this)" value="<?php if(isset($cena)) echo $cena; ?>" />
  </li>
  <li>
    <label for="nieblokuj">Wstaw produkt do sprzedaży</label> 
    <input type="checkbox" name="nieblokuj" <?php if($nieblokuj) echo 'checked '; ?>/>
    <span>Jeśli to pole nie będzie zaznaczone, produkt zostanie dodany do bazy, ale nie będzie wyświetlany klientom i nie będzie możliwe jego kupno.</span>
  </li>
  <li>
    <label for="stan_magazyn">Ilość sztuk w magazynie</label>
    <input type="number" name="stan_magazyn" value="<?php echo isset($stan_magazyn)?$stan_magazyn:0; ?>" onchange="intformat(this)" />
  </li>
  <li>
  	<input type="submit" value="<?php echo isset($produkt_id)?'Zapisz zmiany':'Dodaj produkt';?>">
  </li>
  </ul>
</form>