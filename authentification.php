<?php

// Vérifie si l'utilisateur n'est PAS connecté
if (!isset($_SESSION["mel"])) {

    // Vérifie si le formulaire de connexion n'a pas encore été envoyé
    if (!isset($_POST['btnconnexion'])) {
        ?>
        <!-- Affichage du formulaire de connexion -->
        <form method="post" class="couleur1"> 
            <h5>Votre mail :</h5>
            <input name="mel" class="form-control" type="text">

            <h5>Votre mot de passe :</h5>
            <input name="motdepasse" class="form-control" type="password">

            <div class="text-center">
                <!-- Bouton de connexion -->
                 <br>
                <input type="submit" class="btn btn-success" 
                       name="btnconnexion" value="Connexion">
                <br><br>
            </div>
        </form>
        <?php
    } else {

        // Inclusion du fichier de connexion à la base de données
        require_once 'connexion.php';

        // Récupération des données saisies dans le formulaire
        $mel = $_POST['mel']; 
        $motdepasse = $_POST['motdepasse'];

        // Préparation de la requête SQL sécurisée
        $stmt = $connexion->prepare(
            "SELECT * FROM utilisateur 
             WHERE mel=:mel AND motdepasse=:motdepasse"
        );

        // Liaison des paramètres à la requête
        $stmt->bindValue(":mel", $mel); 
        $stmt->bindValue(":motdepasse", $motdepasse); 

        // Définition du mode de récupération des données
        $stmt->setFetchMode(PDO::FETCH_OBJ);

        // Exécution de la requête
        $stmt->execute();

        // Récupération du résultat
        $enregistrement = $stmt->fetch(); 

        // Si un utilisateur est trouvé
        if ($enregistrement) {

            // Création des variables de session
            $_SESSION["mel"] = $mel;
            $_SESSION["prenom"] = $enregistrement->prenom;
            $_SESSION["nom"] = $enregistrement->nom;
            $_SESSION["adresse"] = $enregistrement->adresse;
            $_SESSION["codepostal"] = $enregistrement->codepostal;
            $_SESSION["ville"] = $enregistrement->ville;
            $_SESSION["profil"] = $enregistrement->profil;

            // Redirection selon le profil de l'utilisateur
            if ($_SESSION["profil"] === "admin") {
                header("Location: acceuiladmin.php"); 
            } else {
                header("Location: acceuil.php"); 
            }
            exit();

        } else { 
            // Message affiché en cas d'échec de connexion
            echo "Échec de la connexion.";
            header("Refresh:2");
            exit();
        }
    }

} else {
    ?>

    <!-- Affichage des informations de l'utilisateur connecté -->
    <h5 class="text-center couleur1">
        <?php echo $_SESSION["prenom"] . ' ' . $_SESSION["nom"]; ?>
    </h5>

    <h5 class="text-center couleur1">
        <?php echo $_SESSION["mel"]; ?>
    </h5>

    <br>

    <h5 class="text-center couleur2">
        <?php echo $_SESSION["adresse"]; ?>
    </h5>

    <h5 class="text-center couleur2">
        <?php echo $_SESSION["codepostal"] . ', ' . $_SESSION["ville"]; ?>
    </h5>

    <!-- Message affiché selon le profil -->
    <?php if ($_SESSION["profil"] === "client"): ?>
        <br><h5 class="text-center couleur3">Bienvenue client</h5>
    <?php endif; ?>

    <?php if ($_SESSION["profil"] === "admin"): ?>
        <br><h5 class="text-center couleur3">Bienvenue administrateur</h5>
    <?php endif; ?>

    <!-- Bouton de déconnexion -->
    <?php if (!isset($_POST['deco'])) { ?>
        <form method="post">
            <div class="input-group-btn text-center">
                <button class="btn btn-danger" name="deco" type="submit">
                    Déconnexion
                </button>
            </div>
        </form>

    <?php } else {

        // Suppression des variables de session
        session_unset();         

        // Destruction de la session
        session_destroy();

        // Redirection vers la page d'accueil après déconnexion
        header("Location: acceuil.php");
        exit();
    }
}

// Termine la mise en mémoire tampon de sortie
ob_end_flush();
?>