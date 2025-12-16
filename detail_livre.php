<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>barre recherche</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</head>
<body>
        <div class="container-fluid">
                <div class="row" >
                          <div class="col-sm-12">
                                    <?php
                              require_once("recherche.php")
                                    ?>
                          </div>
                </div>
                <div class="row">
                      <div class="col-sm-9">
                                <?php
                                    $reponse=$_POST["reponse"];
                                    require_once('connexion.php');
                                    $stmt = $connexion ->prepare("SELECT * from livre INNER JOIN auteur ON (livre.noauteur = auteur.noauteur) where nom=:pnom")	;
                                    $stmt->bindValue(":pnom", $reponse);
                                    $stmt->setFetchMode(PDO::FETCH_OBJ);
                                    $stmt->execute();
                                    echo "<table class='table'>";
                                    while ($enregistrement = $stmt->fetch()){
                                        echo "<tr><td><a href='description-livre.php?idlivre=".$enregistrement->nolivre."'method='get'>" . $enregistrement->titre . "</a></td></tr>";
                                        }
                                    echo "</table>";
                                  ?>
                      </div>
                      <div class="col-sm-3" >
                              <?php
                                require_once("authentification.php")
                              ?>
                      </div>
                </div>
        </div>
    
</body>