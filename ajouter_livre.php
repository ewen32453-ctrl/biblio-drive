<?php
require_once('securiter_page.php');
require_once('connexion.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Livre outil admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Lien vers ton CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1 class="couleur1">Ajouter un livre :</h1>

        <?php
        if (isset($_POST['bouton'])) {
            $noauteur = $_POST['noauteur'];
            $titre = $_POST['titre'];
            $isbn13 = $_POST['isbn13'];
            $anneeparution = $_POST['anneeparution'];
            $detail = $_POST['detail'];
            $photo = $_POST['photo'];
            $dateajout = date('Y-m-d H:i:s');

            $stmt = $connexion->prepare("INSERT INTO livre (noauteur, titre, isbn13, anneeparution, detail, photo, dateajout)
            VALUES (:noauteur, :titre, :isbn13, :anneeparution, :detail, :photo, :dateajout)");

            $stmt->bindParam(':noauteur', $noauteur);
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':isbn13', $isbn13);
            $stmt->bindParam(':anneeparution', $anneeparution);
            $stmt->bindParam(':detail', $detail);
            $stmt->bindParam(':photo', $photo);
            $stmt->bindParam(':dateajout', $dateajout);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Livre ajouté avec succès !</div>";
                header("Refresh:3");
            } else {
                echo "<div class='alert alert-danger'>Erreur lors de l'ajout du livre.</div>";
            }
        }

        $stmt_auteurs = $connexion->prepare("SELECT noauteur, nom FROM auteur");
        $stmt_auteurs->execute();
        $auteurs = $stmt_auteurs->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <form action="" method="post">

            <div class="mb-3">
                <a class="btn btn-success" href="ajoute_auteur.php">Ajouter un auteur</a>

                <select class="form-control mt-2" id="noauteur" name="noauteur" required>
                    <?php foreach ($auteurs as $auteur): ?>
                        <option value="<?= $auteur['noauteur']; ?>"><?= $auteur['nom']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre" required>
            </div>

            <div class="mb-3">
                <input type="text" class="form-control" id="isbn13" name="isbn13" placeholder="ISBN13" required>
            </div>

            <div class="mb-3">
                <input type="text" class="form-control" id="anneeparution" name="anneeparution" placeholder="Année de Parution" required>
            </div>

            <div class="mb-3">
                <input type="text" class="form-control form-control-lg" id="detail" name="detail" placeholder="Détails" required style="height: 100px;">
            </div>

            <div class="mb-3">
                <input type="text" class="form-control" id="photo" name="photo" placeholder="Nom de Fichier Photo" required>
            </div>

            <!-- Bouton clignotant -->
            <button type="submit" name="bouton" class="bouton-clignotant">Valider</button>

        </form>
    </div>
</body>
</html>
