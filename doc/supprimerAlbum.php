<?php
include("fonction.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si le formulaire a été soumis
    if (isset($_POST['nom_album'])) {
        // Récupérer le nom de l'album à supprimer
        $nomAlbum = $_POST['nom_album'];
        
        $cnx = connexion("localhost","root","","album");

        // Utiliser une requête préparée pour éviter les problèmes de sécurité
        $sql = "DELETE FROM albums WHERE nomAlb = ?";
        $stmt = mysqli_prepare($cnx, $sql);

        // Liaison du paramètre
        mysqli_stmt_bind_param($stmt, "s", $nomAlbum);

        // Exécution de la requête
        $res = mysqli_stmt_execute($stmt);
        if (!$res) {
            echo "Erreur lors de la suppression de l'album : " . mysqli_error($cnx);
            exit();
        }

        mysqli_stmt_close($stmt);
        mysqli_close($cnx);

        // Rediriger l'utilisateur vers une page de confirmation ou vers la page d'accueil, par exemple
        header('Location: confirmSup.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="supprimerAlbum.css">
    </head>

    <body>
        <header>
            <h1><a href="index.php">Supprimer un album</a></h1>
        </header>

        <form method="POST" action="">
            <div class="sure">
                <label for="nom_album">Nom de l'album à supprimer :</label>
                <input type="text" id="nom_album" name="nom_album" required>
            </div>
            <button type="submit">Supprimer</button>
        </form>
        
    </body>
</html>