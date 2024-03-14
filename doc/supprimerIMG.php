<?php
if (empty($_POST)){
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Confirmation de suppression</title>
        <link rel="stylesheet" href="supprimerIMG.css">
    </head>
    <body>
        <header>
            <h1><a href="index.php">Confirmation de suppression</a></h1>
        </header>
        <form action="supprimerIMG.php?idPh=<?= $_GET['idPh'] ?>" method="POST">
            <p>Êtes-vous sûr de vouloir supprimer toutes les photo ?</p>
            <button class="bouton" type="submit" name="envoi">Je veux supprimer ces photo</button>
        </form>
    </body>
</html>



<?php
}else{
    $msg = '';
    include("fonction.php");
    $cnx = connexion("localhost","root","","album");
    
    $idPhoto = $_GET['idPh'];
    
    // Récupérer le nom de la photo avant de la supprimer
    $sqlSelect = "SELECT nomPh FROM photos WHERE idPh = $idPhoto";
    $resSelect = mysqli_query($cnx, $sqlSelect);
    $row = mysqli_fetch_assoc($resSelect);
    $nomPh = $row['nomPh'];
    
    // Supprimer la référence à la photo dans la table "comporter"
    $sqlDeleteComporter = "DELETE FROM comporter WHERE idPh = $idPhoto";
    mysqli_query($cnx, $sqlDeleteComporter);
    
    // Supprimer la photo de la table "photos"
    $sqlDeletePhoto = "DELETE FROM photos WHERE idPh = $idPhoto";
    mysqli_query($cnx, $sqlDeletePhoto);
    
    // Emplacement sur mon PC où se trouvent les images
    $uploadDirectory = "./photos/";
    
    // Supprimer le fichier image du répertoire
    $filePath = $uploadDirectory . $nomPh;
    if (file_exists($filePath)) {
        unlink($filePath);
        $msg = "La photo a été supprimée avec succès.";
    } else {
        $msg = "Erreur : Le fichier image n'a pas pu être trouvé.";
    }
    
    mysqli_close($cnx);
    
    // Rediriger l'utilisateur vers une page de confirmation ou une autre page
    header('Location: confirmSup.php?message=' . urlencode($msg));
    exit();
} 

/*else {
    $msg = "Erreur : L'identifiant de la photo n'a pas été fourni.";
    }*/ 
?>