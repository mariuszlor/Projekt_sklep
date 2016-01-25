<div class="menu glowne">
	<ul class="menu glowne">
		<li><a href="glowna.html">Strona główna</a></li>
		<li class="active"><a href="#">Kategorie produktów</a>
			<ul>
				<?php echo gen_menu($kategorie); ?>
			</ul>
		</li>
		<li class="active"><a href="#">Panel administracyjny</a>
			<ul>
				<?php if(pracownik_zalogowany()) { ?>
					<?php if(upr::maUprawnienia(upr::kategoria)) { ?>
						<li><a href="kategoria.html">Dodaj / edytuj kategorie</a></li>
					<?php } ?>
					<?php if(upr::maUprawnienia(upr::produkt)) { ?>
						<li><a href="produkt-edycja.html">Dodaj produkt</a></li>
						<li><a href="produkt-edycja-lista.html">Edytuj produkty</a></li>
					<?php } ?>
					<?php if(upr::maUprawnienia(upr::wysylka)) { ?>
						<li><a href="#">Kompletuj zamówienia do wysyłki</a></li>
					<?php } ?>
					<?php if(upr::maUprawnienia(upr::klient)) { ?>
						<li><a href="baza_klientow.html">Baza klientów</a></li>
					<?php } ?>
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
				<li><a href="profil.html">Ustawienia konta</a></li>
				<?php } else { ?>
				<li><a href="rejestracja.html">Rejestracja</a></li>
				<li><a href="login.html">Logowanie</a></li>
				<?php } ?>
				<li><a href="koszyk.html">Twój koszyk</a>
			</ul>
		</li>
	</ul>
</div>