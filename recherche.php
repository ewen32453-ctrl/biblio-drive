<!DOCTYPE html>
<html lang="fr">
 <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel = "stylesheet" href="style.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<h5>La Bibliothéque de Moulinsart est fermé au public jusqu'a nouvel ordre Mais il vous est possible de reserver et de retirer vos livre via notre service Biblio-Drive !</h5>
<body class="container">

        <nav class="navbar navbar-expand-sm"> <!-- la navbar -->
            <form action = "listerlivre.php" method = "get" >
            <input type="texte" placeholder="Rechercher dans le catalogue (saisir le nom de l'auteur )"name="nom"size="68"><!-- texte dans la navbar -->
           <input type="submit" name="rechercher" value="rechercher">
           

          
       
            </form>
        </nav>
        <?php
          if (isset($_REQUEST["rechercher"])){
            require_once('connexion.php');
            $nom = $_GET['nom'];
            $select = $connexion->prepare("SELECT titre,nolivre FROM auteur, livre WHERE auteur.noauteur = livre.noauteur and auteur.nom=:nom");//on selection le titre et le nolivre dans auteurs .noauteur 
            $select->bindValue(":nom",$nom);// pour eviter la conncatenation 
            $select->setFetchMode(PDO::FETCH_OBJ);
            $select->execute();// on execute la requete 
            while($enregistrement = $select->fetch())
              {
              }
            }
        ?>
</booy>