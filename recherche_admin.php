<?php
require_once('securiter_page.php');?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body class="container py-4">

    <!-- Message d'information -->
    <div class="alert alert-warning text-center" role="alert">
        <h5 class="mb-0">
            La Bibliothèque de Moulinsart est fermée au public jusqu'à nouvel ordre.
            <br>Mais il vous est possible de réserver et de retirer vos livres via notre service <strong>Biblio-Drive</strong> !
        </h5>
    </div>

   

	<form class="form-inline flex-grow-1" action="ajouter_utilisateur.php" method="post">
           
         
            <button type="submit" class="btn btn-multicolor" name="ajouter utilisateur">
               ajouter utilisateur
            </button>
        </form>
		<br><br>
		<form class="form-inline flex-grow-1" action="ajouter_livre.php" method="post">
            <button type="submit" class="btn btn-multicolor" name="ajouter livre">
              ajouter livre
            </button>
        </form>

    </nav>

</body>
</html>