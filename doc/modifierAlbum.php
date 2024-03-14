<?php
$msg='';
include("fonction.php");
$cnx = connexion("localhost","root","","album");

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nom_album'], $_POST['id_album'])) {
        // Récupérer les données du formulaire
        $nomAlbum = $_POST['nom_album'];
        $idAlbum = $_POST['id_album'];

        // Vérifier si le nom d'album existe déjà
        $sqlCheck = "SELECT COUNT(*) FROM albums WHERE nomAlb = '$nomAlbum' AND idAlb != $idAlbum";
        $resCheck = mysqli_query($cnx, $sqlCheck);
        $count = mysqli_fetch_array($resCheck)[0];

        if ($count > 0) {
            $msg= "Erreur : cet album existe déjà.";
        } else {
            // Modifier le nom de l'album dans la base de données
            $sqlUpdate = "UPDATE albums SET nomAlb = '$nomAlbum' WHERE idAlb = $idAlbum";
            $resUpdate = mysqli_query($cnx, $sqlUpdate);
            if (!$resUpdate) {
                echo "Erreur lors de la modification de l'album : " . mysqli_error($cnx);
                exit();
            }

            // Rediriger l'utilisateur vers une page de confirmation ou vers la page de l'album nouvellement créé
            header('Location: confirmAdd.php');
            exit();
        }
    }
}

// Récupérer la liste des albums depuis la base de données
$sqlAlbums = "SELECT * FROM albums";
$resAlbums = mysqli_query($cnx, $sqlAlbums);
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="modifierAlbum.css">
    </head>

    <body>
    <header>
        <h1><a href="index.php">Modifier un album</a></h1>
    </header>

    <form method="POST" action="modifierAlbum.php">
        <div class="choix">
            <label for="id_album">Choisir l'album à modifier :</label>

            <select name="id_album" id="id_album">
                <?php while ($row = mysqli_fetch_assoc($resAlbums)) : ?>
                    <option value="<?php echo $row['idAlb']; ?>"><?php echo $row['nomAlb']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="mdf">
            <label for="nom_album">Nouveau nom de l'album :</label>
            <input type="text" id="nom_album" name="nom_album" required>
        </div>

        <button type="submit">Modifier</button>
    </form>

    <?php echo $msg; ?>
    </body>
</html>