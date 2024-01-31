<?php
$msg='';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérifier si le formulaire a été soumis
    if (isset($_POST['nom_album'])) {
        // Récupérer les données du formulaire
        $cnx = mysqli_connect("localhost", "root", "", "album");
        if (mysqli_connect_errno()) {
            echo "Echec de la connexion : " . mysqli_connect_error();
            exit();
        }

        $nomAlbum = $_POST['nom_album'];

        // Vérifier si le nom d'album existe déjà
        $sqlCheck = "SELECT COUNT(*) FROM albums WHERE nomAlb = '$nomAlbum'";
        $resCheck = mysqli_query($cnx, $sqlCheck);
        $count = mysqli_fetch_array($resCheck)[0];

        if ($count > 0) {
            $msg= "Erreur : cet album existe déjà.";
        }
        else{
            // Insérer l'album dans la base de données
            $sqlInsert = "INSERT INTO albums (nomAlb) VALUES ('$nomAlbum')";
            $resInsert = mysqli_query($cnx, $sqlInsert);
            if (!$resInsert) {
                echo "Erreur lors de la création de l'album : " . mysqli_error($cnx);
                exit();
            }

            mysqli_close($cnx);

            // Rediriger l'utilisateur vers une page de confirmation ou vers la page de l'album nouvellement créé
            header('Location: confirmAdd.php');
        }   
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="ajouterAlbum.css">
    </head>
    <body>
        <header>
            <h1><a href="index.php">Créer un nouvel album</a></h1>
        </header>
        <form method="POST" action="ajouterAlbum.php">
            <label for="nom_album">Nom de l'album :</label>
            <input type="text" id="nom_album" name="nom_album" required>
            <button type="submit">Créer</button>
        </form>
        <?php echo $msg; ?>
    </body>
</html>