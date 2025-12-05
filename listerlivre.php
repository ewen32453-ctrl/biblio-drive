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
                <?php include "recherche.php"; ?>
            </div>

 
            <div class="col-sm-3">
                <img src="chateau.jpg" class="img-fluid" alt="Château">
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-sm-9">
                <?php
                require_once('connexion.php');

                if (isset($_POST["nom"])) {
                    $nom = $_POST["nom"];              
                    $stmt = $connexion->prepare(" SELECT nolivre, titre, anneeparution, noauteur  FROM livre  INNER JOIN auteur ON livre.noauteur = auteur.noauteur  WHERE auteur.nom = :nom  ORDER BY anneeparution");
                    $stmt->bindValue(":nom", $nom, PDO::PARAM_STR);
                    $stmt->setFetchMode(PDO::FETCH_OBJ);
                    $stmt->execute(); 
                    while ($enregistrement = $stmt->fetch()) {
                        echo "
                                <a class='couleur1' href='page_detail.php?nolivre=" . $enregistrement->nolivre . "'>
                                    " . htmlspecialchars($enregistrement->titre) . " (" . $enregistrement->anneeparution . ")
                                </a>";
                    }
                }
                ?>
            </div>
            <div class="col-sm-3">
                <?php include "authentification.php"; ?>
            </div>
        </div>
    </div>
</body>
</html>
