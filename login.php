<div class="container mt-3">
  <h2>Se connecter</h2>

<?php
session_start();

if (!isset($_POST['btnSeConnecter'])) { 
    echo '
    <form method="post">
        <div class="mb-3 mt-3">
            <label for="identifiant">Identifiant:</label>
            <input type="text" class="form-control" id="identifiant"
                   placeholder="Entrer votre identifiant" name="identifiant">
        </div>

        <div class="mb-3">
            <label for="motdepasse">Mot de passe:</label>
            <input type="password" class="form-control" id="mdp"
                   placeholder="Entrer votre Mot de passe" name="motdepasse">
        </div>

        <button type="submit" name="btnSeConnecter" class="btn btn-primary">
            connexion
        </button>
    </form>';
} else {

    require_once 'connexion.php';

    $mel = $_POST['identifiant'];
    $motdepasse = $_POST['motdepasse'];

    $stmt = $connexion->prepare(
        "SELECT * FROM utilisateur 
         WHERE identifiant = :mel 
         AND motdepasse = :motdepasse"
    );

    $stmt->bindValue(":mel", $mel); 
    $stmt->bindValue(":motdepasse", $motdepasse); 
    $stmt->setFetchMode(PDO::FETCH_OBJ);
    $stmt->execute();

    $enregistrement = $stmt->fetch(); 

    if ($enregistrement) { 
        echo '<h1>Connexion réussie !</h1>';
    } else { 
        echo "Echec à la connexion.";
    }
}
?>
</div>