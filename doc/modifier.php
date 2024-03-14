<?php
$msg = '';
include("fonction.php");
$cnx = connexion("localhost","root","","album");

/**********************************************************
 ******* Traitement du formulaire
 **********************************************************/

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['envoi'])) {
    // Récupérer les données du formulaire
    $photoId = $_GET['idPh'];
    $sql="DELETE FROM comporter WHERE idPh=".$photoId;
    mysqli_query($cnx, $sql);

    foreach ($_POST['newAlbums'] as $albumId){
        $sql= "INSERT INTO comporter (idPh, idAlb) VALUES ($photoId, $albumId)";
        mysqli_query($cnx, $sql);
    }
    
    // Rediriger l'utilisateur vers une page de confirmation
    header('Location: confirmAdd.php');

}


/**********************************************************
 ******* Affichage du formulaire
 **********************************************************/

$sql= "SELECT * FROM `comporter` WHERE idPh=".$_GET['idPh'];
$res=mysqli_query($cnx, $sql);
$tbAlbumId=array();
while ($row = mysqli_fetch_assoc($res)) {
    $tbAlbumId[]=$row["idAlb"];
}

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Dupliquer une photo</title>
        <link rel="stylesheet" href="modifier.css">
    </head>
    <body>
        <header>
            <h1><a href="index.php">Dupliquer une photo</a></h1>
        </header>

        <form action="modifier.php?idPh=<?= $_GET['idPh'] ?>" method="post">
            <label>Choisir les nouveaux albums :</label>

            <div class="choix">
                <?php
                // Récupérer la liste des albums depuis la base de données
                $sqlAlbums = "SELECT * FROM albums";
                $resAlbums = mysqli_query($cnx, $sqlAlbums);

                while ($row = mysqli_fetch_assoc($resAlbums)) {
                    $checked="";
                    if(in_array($row["idAlb"], $tbAlbumId)){
                        $checked=" checked ";
                    }
                    echo '<label><input '.$checked.' type="checkbox" name="newAlbums[]" value="' . $row['idAlb'] . '">' . $row['nomAlb'] . '</label>';
                }
                ?>
            </div>

            <div class="clik">
                <button class="bouton" type="submit" name="envoi">Déplacer</button>
            </div>
        </form>
    </body>
</html>