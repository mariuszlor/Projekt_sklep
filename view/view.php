<?php include('head.php'); ?>
<body>
<div id="top">
<div id="top_inner">
<img src="img/sklep_logo.png" alt="LOGO"  />
<h1>Sklep internetowy</h1>
</div>
</div>
<div id="container">
	<div id="left">	
		<?php include('menu.php'); ?>	
	</div>
	<div id="content">
	<?php include('message.php'); ?>
	<?php if(isset($content)) echo $content; ?>
	</div>
</div>
<div id="footer">
	<div>Autorzy: Mariusz Lorek, Piotr Jabłoński</div>
</div>
</body>
</html>