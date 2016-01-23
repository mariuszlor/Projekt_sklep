<h2>Baza zarejestrowanych klientów</h2>
<h3>Klienci indywidualni</h3>
<?php 
if(count($kliencip)==0) { ?>
Brak zarejestrowanych klientów indywidualnych.
<?php } else { ?>
<ul>
<?php foreach($kliencip as $klientp) { ?>
<li><?php echo $klientp['imie'].' '.$klientp['nazwisko']; ?></li>
<?php } ?>
</ul>
<?php } ?>
<h3>Konta firmowe</h3>
<?php 
if(count($kliencif)==0) { ?>
Brak zarejestrowanych kont firmowych.
<?php } else { ?>
<ul>
<?php foreach($kliencif as $klientf) { ?>
<li><?php echo $klientf['nazwa_firmy'].', NIP '.$klientf['NIP']; ?></li>
<?php } ?>
</ul>
<?php } ?>
