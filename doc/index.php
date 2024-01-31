<?php
$cnx = mysqli_connect ("localhost","root","","album");

    if (mysqli_connect_errno()) {
      echo "Echec de la connexion : ",mysqli_connect_error();
      exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
  <header>
    <h1><a href="index.php">Albums</a></h1>
    <nav>
  <?php
    $sql = "SELECT * from albums";
    $res = mysqli_query($cnx, $sql);
    
    echo '<a href="supprimerAlbum.php"><img src="photos/Pubelle.png"></a>';
    while($ligne = mysqli_fetch_array($res)) {
      echo '<a href="index.php?id='.$ligne['idAlb'].'">'.$ligne['nomAlb'].'</a>';
    }
    echo '<a href="ajouterAlbum.php"><img src="photos/Plus.png"></a>';
  ?>
    </nav>

  </header>

  <main>
    
    
      <?php
      if (isset($_GET["id"])){
        echo '<a href="modifier.php"><img class="modif" src="photos/stylo.png"></a>';
      } 
      ?>
    

    <?php
    $sql = "SELECT * FROM photos, comporter WHERE comporter.idPh = photos.idPh AND idAlb=".$_GET["id"];

    $res = mysqli_query($cnx, $sql);

    echo "<div class ='pimg'>";
    while($ligne = mysqli_fetch_array($res)) {
      echo "<div>";
      echo '<a href="grand.php?idPh='.$ligne["idPh"].'"><img src="photos/'.$ligne["nomPh"].'" /></a>';
      echo "</div>";
    }
    echo "</div>";
    mysqli_free_result($res);

    mysqli_close($cnx);
    ?>
  </main>
</body>

</html>