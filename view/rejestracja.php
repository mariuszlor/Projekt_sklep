<h2>Klient - logowanie</h2>
<p>Aby utworzyć nowe konto, wprowadź login, adres e-mail i hasło</p>
<form class="formularz" action="rejestracja.html" method="post" >
<ul>
<li>
<label for="login">Typ konta</label>
<select name="typkonta" >
<option value="p">Osoba prywatna</option>
<option value="f">Firma</option>
</select>
</li>
<li>
<label for="login">Login</label>
<input type="text" name="login" value="<?php if(isset($_POST['login']))echo $_POST['login']; ?>" >
</li>
<li>
<label for="password">Hasło</label>
<input type="password" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password']; ?>" >
</li>
<li>
<input type="submit">
</li>
</ul>
</form>
<br>