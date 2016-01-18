<h2>Zarządzanie profilem</h2>
<?php if(klient::$typ=='p') { ?>
<form class="formularz" action="profil.html" method="post" >
<h1>Zmiana danych</h1>
<ul>
<li>
<label for="imie">Imię</label>
<input type="text" name="imie" value="<?php echo klient::$imie; ?>" >
</li>
<li>
<label for="nazwisko">Nazwisko</label>
<input type="text" name="nazwisko" value="<?php echo klient::$nazwisko; ?>" >
</li>
<li>
<label for="dom_adr_wys">Domyślny adres wysyłki</label>
<textarea name="dom_adr_wys"><?php echo klient::$dom_adr_wys; ?></textarea>
</li>
<li>
<input type="submit">
</li>
</ul>
</form>
<?php } ?>
<?php if(klient::$typ=='f') { ?>
<form class="formularz" action="profil.html" method="post" >
<h1>Zmiana danych</h1>
<ul>
<li>
<label for="nazwa_firmy">Nazwa firmy</label>
<input type="text" name="nazwa_firmy" value="<?php echo klient::$nazwa_firmy; ?>" >
</li>
<li>
<label for="NIP">NIP</label>
<input type="text" name="NIP" value="<?php echo klient::$NIP; ?>" >
</li>
<li>
<label for="dom_adr_wys">Domyślny adres wysyłki</label>
<textarea name="dom_adr_wys"><?php echo klient::$dom_adr_wys; ?></textarea>
</li>
<li>
<input type="submit">
</li>
</ul>
</form>
<?php } ?>
<form class="formularz" action="profil.html" method="post" >
<h1>Zmiana hasła</h1>
<ul>
<li>
<label for="password">Obecne hasło</label>
<input type="password" name="password" >
</li>
<li>
<label for="newPassword">Nowe hasło</label>
<input type="password" name="newPassword" >
</li>
<li>
<label for="newPassword2">Powtórz nowe hasło</label>
<input type="password" name="newPassword2" >
</li>
<li>
<input type="submit">
</li>
</ul>
</form>
