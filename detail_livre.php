<?php
session_start();
ob_start(); // Cette fonction active la mise en mémoire tampon de la sortie jusqu'a la deconnexion
?>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-9">
                <?php include "recherche.php" ?>
            </div>

            <div class="col-sm-3">
                <img src="chateau.jpg">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-9">
                <?php
                require_once('connexion.php');

                $stmt = $connexion->prepare("
                    SELECT nom, prenom, dateretour, detail, isbn13, anneeparution, photo, titre
                    FROM livre
                    INNER JOIN auteur ON (livre.noauteur = auteur.noauteur)
                    LEFT OUTER JOIN emprunter ON (livre.nolivre = emprunter.nolivre)
                    WHERE livre.nolivre = :nolivre
                ");

                $nolivre = $_GET["nolivre"];
                $stmt->bindValue(":nolivre", $nolivre);
                $stmt->setFetchMode(PDO::FETCH_OBJ);
                $stmt->execute();

                $enregistrement = $stmt->fetch();
                ?>

                <div class="row">
                    <div class="col-sm-8">
                        <?php
                        echo "ISBN13 : " . $enregistrement->isbn13;
                        echo "<br>";
                        echo "Auteur : " . $enregistrement->prenom . " " . $enregistrement->nom;
                        echo "Titre : " . $enregistrement->titre . " " . $enregistrement->anneeparution;
                        echo "<br><br>";
                        echo "Résumé du livre :<br>";
                        echo $enregistrement->detail;
                        ?>
                    </div>

                    <div class="col-sm-4">
                        <img src="./images-couvertures/covers/<?php echo $enregistrement->photo; ?>"
                             class="d-block w-100"
                             alt="Image de couverture">
                    </div>

                    <?php
                    if (isset($_SESSION["prenom"])) {
                        echo '<form method="POST">';
                        echo '<input type="submit" name="btn-ajoutpanier" class="btn btn-success btn-lg" value="Ajouter au panier">';
                        echo '</form>';
                    } else {
                        echo '<p class="text-primary">
                                Pour pouvoir réserver ce livre vous devez posséder un compte et vous identifier !
                              </p>';
                    }

                    if (!isset($_SESSION['panier'])) {
                        $_SESSION['panier'] = array();
                    }

                    if (isset($_POST['btn-ajoutpanier'])) {
                        array_push($_SESSION['panier'], $enregistrement->titre);
                        echo "Livre ajouté à votre panier :)";
                    }
                    ?>
                </div>

                <p>
                    <a href="acceuil.php" class="btn btn-primary mt-3">
                        ← Retour à l'accueil
                    </a>
                </p>
            </div>

            <div class="col-sm-3">
                <?php include "authentification.php" ?>
            </div>
        </div>
    </div>
</body>
</html>