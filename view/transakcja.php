<?php if(isset($transakcja)) { ?>
<h2>Szczegóły transakcji</h2>
<p>Status transakcji: 
<?php echo transakcja::status($transakcja['status']); ?>
</p>
<h3>Kupione towary</h3>
<?php 
foreach($towary_kupione as $towar) {
	echo '<h4>'.$towar['nazwa'].' x'.$towar['sztuk'].' po '.$towar['cena'].' sztuka</h4>';
	echo $towar['opis'];
}
} else { ?>
<h2>Nieznana transakcja</h2>
<?php } ?>