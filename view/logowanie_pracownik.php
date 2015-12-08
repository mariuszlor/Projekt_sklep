<h2>Pracownik - logowanie</h1>
<p>Aby zalogować się na konto, wprowadź login i hasło</p>
<form action="login-pracownik.html" method="post" >
  <b>Login:</b><input type="text" name="login" value="<?php if(isset($_POST['login']))echo $_POST['login']; ?>" ><br />
  <b>Hasło:</b><input type="password" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password']; ?>" ><br />
  <input type="submit"><br>
</form>
<br>