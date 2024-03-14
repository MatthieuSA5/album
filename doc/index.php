<?php
include("fonction.php");
$cnx = connexion("localhost","root","","album");

    if (!isset($_GET["id"])){
      $sql = "SELECT * from albums";
      $res = mysqli_query($cnx, $sql);
      $id= mysqli_fetch_array($res)["idAlb"];
      $_GET["id"] = $id;
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
      echo '<a href="modifierAlbum.php"><img src="photos/mdf.png"></a>';
      while($ligne = mysqli_fetch_array($res)) {
        echo '<a href="index.php?id='.$ligne['idAlb'].'">'.$ligne['nomAlb'].'</a>';
      }
      echo '<a href="ajouterAlbum.php"><img src="photos/Plus.png"></a>';
      echo '<a href="AjouterIMG.php?id='.$_GET['id'].'"><img src="photos/AjouterIMG.png"></a>';
    ?>
      </nav>

    </header>

    <main>

      <?php
      $sql = "SELECT * FROM photos, comporter WHERE comporter.idPh = photos.idPh AND idAlb=".$_GET["id"];

      $res = mysqli_query($cnx, $sql);

      echo "<div class ='pimg'>";
      while ($ligne = mysqli_fetch_array($res)) {
        echo '<a href="photos/' . $ligne["nomPh"] . '" target="_blank"><img src="photos/' . $ligne["nomPh"] . '" id="image_' . $ligne["idPh"] . '"/></a>';
        echo '<a href="modifier.php?idPh=' . $ligne["idPh"] . '"><img src="photos/stylo.png" alt="Modifier" title="Modifier" class="Icon"></a>';
        echo '<a href="SupprimerIMG.php?idPh=' . $ligne["idPh"] . '"><img src="photos/SupprimerIMG.png" alt="Supprimer" title="Supprimer" class="Icon"></a>';
      }
      echo "</div>";
      mysqli_free_result($res);

      mysqli_close($cnx);
      ?>

    </main>
  </body>

</html>