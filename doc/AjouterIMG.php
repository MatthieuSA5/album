<?php
$msg = '';
include("fonction.php");
$cnx = connexion("localhost","root","","album");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si le formulaire a été soumis
    if (isset($_POST['envoi'])) {
        // Récupérer les données du formulaire
        if (mysqli_connect_errno()) {
            echo "Echec de la connexion : " . mysqli_connect_error();
            exit();
        }

        // Insérer la photo dans la base de données
        $sqlInsert = "INSERT INTO photos (nomPh) VALUES ('')";
        $resInsert = mysqli_query($cnx, $sqlInsert);
        $id = mysqli_insert_id($cnx);

        if (!$resInsert) {
            echo "Erreur lors de l'ajout de la photo : " . mysqli_error($cnx);
            exit();
        }

        $nomPh = "ph_" . $id . ".jpg";
        $sqlUpdate = "UPDATE photos SET nomPh = '$nomPh' WHERE idPh=" . $id;
        $resUpdate = mysqli_query($cnx, $sqlUpdate);

        // Récupérer les albums sélectionnés
if (isset($_POST['albums']) && !empty($_POST['albums'])) {
    $selectedAlbums = $_POST['albums'];
    foreach ($selectedAlbums as $albumId) {
        $sqlComporter = "INSERT INTO comporter (idPh, idAlb) VALUES ('$id', '$albumId')";
        mysqli_query($cnx, $sqlComporter);
    }
} else {
    echo "Veuillez choisir au moins un album.";
    mysqli_close($cnx);
    exit();
}

// Emplacement sur le serveur où vous souhaitez enregistrer les images
$uploadDirectory = "./photos/";

// Déplacer l'image téléchargée vers le répertoire sur le serveur
$targetPath = $uploadDirectory . $nomPh;

if (move_uploaded_file($_FILES['photos']['tmp_name'], $targetPath)) {
    echo "L'image a été téléchargée avec succès.";
} else {
    echo "Erreur lors de l'enregistrement de l'image sur le serveur.";
}

mysqli_close($cnx);

// Rediriger l'utilisateur vers une page de confirmation
header('Location: confirmAdd.php');
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Ajouter une image</title>
        <link rel="stylesheet" href="AjouterIMG.css">
    </head>
    <body>
        <header>
            <h1><a href="index.php">Ajouter une photo</a></h1>
        </header>

        <form action="AjouterIMG.php?id=<?= $_GET['id'] ?>" method="post" enctype="multipart/form-data">
            <label for="photos">Choisir une photo :</label>
            <input type="file" name="photos" id="id_Ph" accept="image/*" required>

            <div class="choix">
            <label>Choisir des albums :</label>
            <?php
            // Récupérer la liste des albums depuis la base de données
            $sqlAlbums = "SELECT * FROM albums";
            $resAlbums = mysqli_query($cnx, $sqlAlbums);

            while ($row = mysqli_fetch_assoc($resAlbums)) {
                echo '<label><input type="checkbox" name="albums[]" value="' . $row['idAlb'] . '">' . $row['nomAlb'] . '</label>';
            }
            ?>
            </div>
            
            <div classe="clik">
                <button class="bouton" type="submit" name="envoi">Ajouter la photo</button>
            </div>
        </form>
    </body>
</html>