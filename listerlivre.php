<?php
session_start();
ob_start(); // Cette fonction active la mise en mémoire tampon de la sortie jusqu'a la deconnexion
?>
<body>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-9">
                <?php include "recherche.php"; ?>
            </div>

 
            <div class="col-sm-3">
                <img src="chateau.jpg"  >					
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-sm-9">
                <?php
                require_once('connexion.php');

                if (isset($_POST["nom"])) {
                    $nom = $_POST["nom"];              
                    $stmt = $connexion->prepare(" SELECT nolivre, titre, anneeparution, livre.noauteur  FROM livre  INNER JOIN auteur ON livre.noauteur = auteur.noauteur  WHERE auteur.nom = :nom  ORDER BY anneeparution");
                    $stmt->bindValue(":nom", $nom, PDO::PARAM_STR);
                    $stmt->setFetchMode(PDO::FETCH_OBJ);
                    $stmt->execute(); 
                    while ($enregistrement = $stmt->fetch()) {
                        echo "
                                <a class='couleur1' href='detail_livre.php?nolivre=" . $enregistrement->nolivre . "'>
                                    " . $enregistrement->titre . " (" . $enregistrement->anneeparution . ")
                                    
                                    <br><br>
                                </a>";
                    }
                }
                ?>
                <br><br>
                <p>
                    <a href="acceuil.php" class="btn btn-primary mt-3">
                        ← Retour à l'accueil
                    </a>
                </p>
            </div>
            
            
            <div class="col-sm-3">
                <?php include "authentification.php"; ?>
            </div>
        </div>
    </div>
</body>
</html>
