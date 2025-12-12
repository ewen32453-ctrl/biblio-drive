<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
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
            <?php

            $noLivre=$_POST["nolivre"];

            require_once('connexion.php');

            $select = $connexion->prepare(" SELECT *  FROM livre  INNER JOIN auteur ON auteur.noauteur = livre.noauteur WHERE livre.noLivre = :NoLivre");
            $select->setFetchMode(PDO::FETCH_OBJ);


            $select->bindValue(":NoLivre", $noLivre, PDO::PARAM_INT);

            $select->execute();
            $enregistrement = $select->fetch();

            if ($enregistrement) {
                echo "<p>Auteur : {$enregistrement->nom} {$enregistrement->prenom}</p>";
                echo "<p>ISBN 13 : {$enregistrement->isbn13}</p>";
                echo "<p>Résumé :</br> {$enregistrement->resume}</p>";
            } 
            ?>


					
			</div>
			<div class="col-sm-3">
					<?php include"authentification.php"?>
					
			</div>
		</div>
	</div>
	</body>
</html>