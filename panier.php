<?php
require_once('connexion.php'); // connexion à la BDD

// --- INITIALISATION DU PANIER ---
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

// --- AJOUT D'UN LIVRE AU PANIER ---
if (isset($_POST['ajouter'])) {
    $nolivre = intval($_POST['nolivre']);
    if ($nolivre > 0 && !in_array($nolivre, $_SESSION['panier'])) {
        $_SESSION['panier'][] = $nolivre;
    }
    header("Refresh:0");
    exit;
}

// --- SUPPRIMER UN LIVRE DU PANIER ---
if (isset($_POST['annuler'])) {
    $index = intval($_POST['index']);
    if (isset($_SESSION['panier'][$index])) {
        unset($_SESSION['panier'][$index]);
        $_SESSION['panier'] = array_values($_SESSION['panier']);
    }
    header("Refresh:0");
    exit;
}

// --- VALIDER LE PANIER ---
if (isset($_POST['valider'])) {
    if (!isset($_SESSION['mel'])) {
        echo '<div class="alert alert-danger">Erreur : utilisateur non connecté !</div>';
        exit;
    }

    $mel = $_SESSION['mel'];
    $dateemprunt = date("Y-m-d");

    foreach ($_SESSION['panier'] as $nolivre) {
        $stmtCheck = $connexion->prepare("SELECT 1 FROM livre WHERE nolivre = ?");
        $stmtCheck->execute([$nolivre]);
        if (!$stmtCheck->fetch()) {
            echo '<div class="alert alert-warning">Erreur : le livre ID ' . $nolivre . ' n\'existe pas !</div>';
            continue;
        }

        try {
            $stmt = $connexion->prepare("INSERT INTO emprunter (mel, nolivre, dateemprunt) 
                                         VALUES (:mel, :nolivre, :dateemprunt)");
            $stmt->bindValue(':mel', $mel, PDO::PARAM_STR);
            $stmt->bindValue(':nolivre', $nolivre, PDO::PARAM_INT);
            $stmt->bindValue(':dateemprunt', $dateemprunt, PDO::PARAM_STR);
            $stmt->execute();

            echo '<div class="alert alert-success">Le livre ID ' . $nolivre . ' a été emprunté avec succès.</div>';

        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">Erreur lors de l\'emprunt du livre ID ' . $nolivre . ' : ' . $e->getMessage() . '</div>';
        }
    }

    $_SESSION['panier'] = array();
    header("Refresh:5");
    exit;
}
?>

<div class="container my-5">

    <!-- Carte Ajouter un livre -->
    <div class="card mb-4 border-primary">
        <div class="card-header bg-primary text-white">
            Ajouter un livre au panier
        </div>
        <div class="card-body">
            <form method="POST" class="row g-3">
                <div class="col-md-8">
                    <select name="nolivre" class="form-select">
                        <?php
                        $stmtLivres = $connexion->query("SELECT nolivre, titre FROM livre ORDER BY titre");
                        while ($row = $stmtLivres->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['nolivre'] . '">' . htmlspecialchars($row['titre']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" name="ajouter" class="btn btn-primary w-100">Ajouter au panier</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Carte Panier -->
    <div class="card border-primary">
        <div class="card-header bg-primary text-white">
            Votre panier
        </div>
        <div class="card-body">
            <?php
            $nb_livresempruntes = count($_SESSION['panier']);
            $nb_emprunts = 5 - $nb_livresempruntes;

            echo '<p class="mb-3">Il vous reste <strong>' . $nb_emprunts . '</strong> réservations possibles.</p>';

            if (empty($_SESSION['panier'])) {
                echo '<div class="alert alert-info">Votre panier est vide !</div>';
            } else {
                $placeholders = implode(',', array_fill(0, count($_SESSION['panier']), '?'));
                $stmt = $connexion->prepare("SELECT nolivre, titre FROM livre WHERE nolivre IN ($placeholders)");
                $stmt->execute($_SESSION['panier']);
                $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $livresAssoc = [];
                foreach ($livres as $livre) {
                    $livresAssoc[$livre['nolivre']] = $livre['titre'];
                }

                foreach ($_SESSION['panier'] as $index => $nolivre) {
                    $titre = $livresAssoc[$nolivre] ?? "Livre inconnu";
                    echo '<form method="POST" class="d-flex mb-2">';
                    echo '<div class="flex-grow-1 p-2 border rounded">' . htmlspecialchars($titre) . '</div>';
                    echo '<input type="hidden" name="index" value="' . $index . '">';
                    echo '<button type="submit" name="annuler" class="btn btn-danger ms-2">Supprimer</button>';
                    echo '</form>';
                }

                echo '<form method="POST">';
                echo '<button type="submit" name="valider" class="btn btn-primary mt-3 w-100">Valider le panier</button>';
                echo '</form>';
            }
            ?>
        </div>
    </div>

</div>