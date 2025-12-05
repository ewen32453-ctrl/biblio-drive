<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Dernière acquisition</h2>  
  <div id="myCarousel" class="carousel slide" data-ride="carousel">

    
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

   
    <div class="carousel-inner">
      <?php
      require_once('connexion.php');
      $select = $connexion->prepare("SELECT * FROM livre ORDER BY dateajout DESC LIMIT 3"); 
      $select->setFetchMode(PDO::FETCH_OBJ);
      $select->execute();

      $i = 0;
      while($enregistrement = $select->fetch()) {
          $active = ($i == 0) ? ' active' : '';
          echo '<div class="item'.$active.'">';
          echo '<img src="images-couvertures/covers/'.$enregistrement->photo.'" alt="Image '.$i.'" style="width:50%;">';
          echo '</div>';
          $i++;
      }
      ?>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Précédent</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Suivant</span>
    </a>
  </div>
</div>

</body>
</html>