<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form action="index.php" method="POST">
        <label for="name">Tape des trucs ma gueule !</label>
        <input type="text" name="titre" required>
        <input type="file" name="affiche" required>
        <input type="text" name="acteur" required>
        <input type="date" name="dateDeSortie" required>
        <input type="text" name="synopsis" required>
        <input type="text" name="realisateur" required>
        <input type="submit" value="Aller go !">
    </form>


    <?php
    include('config.php');


    //READ
    try {
        // instancie un objet $connexion à partir de la classe PDO
        $connexion = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);

        // Requête de sélection 01
        $requete = "SELECT * FROM `med_film`";
        $prepare = $connexion->prepare($requete);
        $prepare->execute();
        $resultat = $prepare->fetchAll();
        foreach ($resultat as $key => $value) {
            print_r($value);
            $id = $value["fi_id"];
            echo ('<form action="modifier.php" method="POST" >');
            echo ('<input type="hidden" name="id" value=' . $id . '>');
            echo ('<input type="submit" value="Modifier">');
            echo ("</form>");

            echo ('<form action="index.php" method="POST" >');
            echo ('<input type="hidden" name="idDelete" value=' . $id . '>');
            echo ('<input type="submit" value="Supprimer">');
            echo ("</form>");
            echo ("<br>");
        }
    } catch (PDOException $e) {
        // en cas d'erreur, on récup et on affiche, grâce à notre try/catch
        exit("❌🙀💀 OOPS :\n" . $e->getMessage());
    }

    //INSERT 
    if (
        isset($_POST['titre']) == true &&
        isset($_POST['affiche']) == true &&
        isset($_POST['acteur']) == true &&
        isset($_POST['dateDeSortie']) == true &&
        isset($_POST['synopsis']) == true &&
        isset($_POST['realisateur']) == true
    ) {
        try {
            $titre = htmlentities($_POST['titre'], ENT_QUOTES); //Récupère la recherche si il y en a une
            $affiche = htmlentities($_POST['affiche'], ENT_QUOTES); //Récupère la recherche si il y en a une
            $acteur = htmlentities($_POST['acteur'], ENT_QUOTES); //Récupère la recherche si il y en a une
            $dateDeSortie = htmlentities($_POST['dateDeSortie'], ENT_QUOTES); //Récupère la recherche si il y en a une
            $synopsis = htmlentities($_POST['synopsis'], ENT_QUOTES); //Récupère la recherche si il y en a une
            $realisateur = htmlentities($_POST['realisateur'], ENT_QUOTES); //Récupère la recherche si il y en a une

            $pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
            $requete = "INSERT INTO `med_film`
                        (`fi_titre`, `fi_affiche`, `fi_acteur`, `fi_dateDeSortie`, `fi_synopsis`, `fi_realisateur` )
                        VALUE (:fi_titre, :fi_affiche, :fi_acteur, :fi_dateDeSortie, :fi_synopsis, :fi_realisateur)";
            $prepare = $pdo->prepare($requete);
            $prepare->execute(array(
                ":fi_titre"   => $titre,
                ":fi_affiche"   => $affiche,
                ":fi_acteur"   => $acteur,
                ":fi_dateDeSortie" => $dateDeSortie,
                ":fi_synopsis" => $synopsis,
                ":fi_realisateur" => $realisateur
            ));
            $resultat = $prepare->fetchAll();
        } catch (PDOException $e) {
            // en cas d'erreur, on récup et on affiche, grâce à notre try/catch
            exit("❌🙀💀 OOPS :\n" . $e->getMessage());
        }
    } //End premier if check si il y a un envoi de variable via le formulaire


    //SUPPRIMER
    if (isset($_POST['idDelete']) == true) {
        $id = $_POST['idDelete'];
        include('config.php');
        try {
            $connexion = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);
            $requete = "DELETE FROM `med_film`
                        WHERE ((`fi_id` = :fi_id));";
            $prepare = $connexion->prepare($requete);
            $prepare->execute(array(
                ':fi_id' => $id
            ));
            $resultat = $prepare->rowCount();
        } catch (PDOException $e) {
            // en cas d'erreur, on récup et on affiche, grâce à notre try/catch
            exit("❌🙀💀 OOPS :\n" . $e->getMessage());
        }
    }

    ?>
</body>

</html>
