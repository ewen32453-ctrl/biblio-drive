<?php
session_start();
ob_start(); // Mise en mémoire tampon
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail du livre</title>
    <link rel="stylesheet" href="bootstrap.css">
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9">
            <?php include "recherche.php"; ?>
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

            // 🔒 Vérification : livre emprunté ou non
            $livreEmprunte = !empty($enregistrement->dateretour);
            ?>

            <div class="row">
                <div class="col-sm-8">
                    <?php
                    echo "ISBN13 : " . $enregistrement->isbn13 . "<br>";
                    echo "Auteur : " . $enregistrement->prenom . " " . $enregistrement->nom . "<br>";
                    echo "Titre : " . $enregistrement->titre . " (" . $enregistrement->anneeparution . ")<br><br>";
                    echo "<strong>Résumé du livre :</strong><br>";
                    echo $enregistrement->detail;

                    if ($livreEmprunte) {
                        echo "<br><br><span class='text-danger fw-bold'>
                                📕 Livre actuellement emprunté
                              </span>";
                    }
                    ?>
                </div>

                <div class="col-sm-4">
                    <img src="./images-couvertures/covers/<?php echo $enregistrement->photo; ?>"
                         class="d-block w-100"
                         alt="Image de couverture">
                </div>

                <?php
                // ---------- BOUTON DE RÉSERVATION ----------
                if (isset($_SESSION["prenom"])) {

                    if ($livreEmprunte) {
                        echo '<p class="text-danger mt-3 fw-bold">
                                Ce livre est déjà emprunté, réservation impossible.
                              </p>';
                    } else {
                        echo '<form method="POST" class="mt-3">';
                        echo '<input type="submit" name="btn-ajoutpanier"
                                     class="btn btn-success btn-lg"
                                     value="Ajouter au panier">';
                        echo '</form>';
                    }

                } else {
                    echo '<p class="text-primary mt-3">
                            Pour pouvoir réserver ce livre, vous devez posséder un compte et vous identifier !
                          </p>';
                }

                // ---------- PANIER ----------
                if (!isset($_SESSION['panier'])) {
                    $_SESSION['panier'] = array();
                }

                if (isset($_POST['btn-ajoutpanier']) && !$livreEmprunte) {
                    if (!in_array($enregistrement->titre, $_SESSION['panier'])) {
                        $_SESSION['panier'][] = $enregistrement->titre;
                        echo "<p class='text-success mt-2'>Livre ajouté à votre panier 🙂</p>";
                    } else {
                        echo "<p class='text-warning mt-2'>Ce livre est déjà dans votre panier.</p>";
                    }
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
            <?php include "authentification.php"; ?>
        </div>
    </div>
</div>
</body>
</html>