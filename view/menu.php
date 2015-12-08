<div class="menu glowne">
	<ul class="menu glowne">
		<li><a href="index.html">Strona główna</a></li>
		<li class="active"><a href="#">Kategorie produktów</a>
			<ul>
				<li><a href="#">Kategoria 1</a></li>
				<li><a href="#">Kategoria 2</a></li>
				<li><a href="#">Kategoria 3</a></li>
			</ul>
		</li>
		<li class="active"><a href="#">Panel administracyjny</a>
			<ul>
				<?php if(isset($_SESSION['pracownik_id'])) { ?>
				<li><a href="#">Dodaj kategorię</a></li>
				<li><a href="#">Dodaj / edytuj kategorie</a></li>
				<li><a href="#">Dodaj produkt</a></li>
				<li><a href="#">Usuń / edytuj produkty</a></li>
				<li><a href="#">Zarządzaj rabatami</a></li>
				<li><a href="logout.html?logout">Wyloguj</a></li>
				<?php } else { ?>
				<li><a href="login-pracownik.html">Logowanie</a></li>
				<?php } ?>
			</ul>
		</li>
		<li class="active"><a href="#">Panel klienta</a>
			<ul>
				<?php if(isset($_SESSION['klient_id'])) { ?>
				<li><a href="logout.html?logout">Wyloguj</a></li>
				<li><a href="#">Ustawienia konta</a></li>
				<?php } else { ?>
				<li><a href="#">Rejestracja</a></li>
				<li><a href="login.html">Logowanie</a></li>
				<?php } ?>
			</ul>
		</li>
		<li class="active"><a href="#">Raporty</a>
			<ul>
				<li><a href="#">Stany magazynowe</a></li>
				<li><a href="#">Sprzedaż za okres...</a></li>
				<li><a href="#">Moje zakupy</a></li>
			</ul>
		</li>
	</ul>
</div>