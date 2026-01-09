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

    <!-- Navbar -->
    <nav class="navbar navbar-expand-sm navbar-light bg-light mb-4 shadow-sm p-3 rounded">
        
        <!-- Formulaire de recherche -->
        <form class="form-inline flex-grow-1" action="listerlivre.php" method="post">
            <input 
                type="text" 
                class="form-control mr-2 w-75" 
                placeholder="Rechercher dans le catalogue (nom de l'auteur)" 
                name="nom"
            >
            <button type="submit" class="btn btn-multicolor" name="rechercher">
                Rechercher
            </button>
        </form>

        <!-- Lien panier -->
       <a href="page_panier.php" class="btn btn-primary mt-3">
         Panier
        </a>

    </nav>

</body>
</html>