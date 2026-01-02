	<?php
	session_start();
	ob_start(); // Cette fonction active la mise en mémoire tampon de la sortie jusqu'a la deconnexion du client
	?>
	<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-9">
				<?php include"recherche.php"?>
					
			</div>
			<div class="col-sm-3">
					<img src="chateau.jpg"  >					
			</div>
		</div>
		<div class="row">
		   <div class="col-sm-9">
				<?php include"panier.php"?>

					
			</div>
			<div class="col-sm-3">
					<?php include"authentification.php"?>
					
			</div>
		</div>
	</div>
	</body>
</html>
	