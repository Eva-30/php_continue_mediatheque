<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier</title>
</head>
    <body>


    <?php 

    $id = $_POST['id'];

    include('config.php');

    if (isset($_POST['titre']) == true&&
    isset($_POST['affiche']) == true&&
    isset($_POST['acteur']) == true&&
    isset($_POST['dateDeSortie']) == true&&
    isset($_POST['synopsis']) == true&&
    isset($_POST['realisateur']) == true){
        //READ
        try {
            // instancie un objet $connexion à partir de la classe PDO
            $connexion = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);




            $titre = htmlentities($_POST['titre'], ENT_QUOTES); //Récupère la recherche si il y en a une
            $affiche = htmlentities($_POST['affiche'], ENT_QUOTES); //Récupère la recherche si il y en a une
            $acteur = htmlentities($_POST['acteur'], ENT_QUOTES); //Récupère la recherche si il y en a une
            $dateDeSortie = htmlentities($_POST['dateDeSortie'], ENT_QUOTES); //Récupère la recherche si il y en a une
            $synopsis = htmlentities($_POST['synopsis'], ENT_QUOTES); //Récupère la recherche si il y en a une
            $realisateur = htmlentities($_POST['realisateur'], ENT_QUOTES); //Récupère la recherche si il y en a une

            // Requête de sélection 01
            $requete = "UPDATE `med_film`
            SET`fi_titre` = :titre, `fi_affiche` = :affiche, `fi_acteur` = :acteur, `fi_dateDeSortie` = :dateDeSortie, `fi_synopsis` = :synopsis, `fi_realisateur` = :realisateur
            WHERE `fi_id` = :fi_id ";
            $prepare = $connexion->prepare($requete);
            $prepare->execute(array(
                ':fi_id' => $id,
                ':titre' => $titre,
                ':affiche' => $affiche,
                ':acteur' => $acteur,
                ':dateDeSortie' => $dateDeSortie,
                ':synopsis' => $synopsis,
                ':realisateur' => $realisateur
            ));
            $resultat = $prepare->fetchAll();
            
            //$resultat = $resultat[0];

            //print_r($resultat['fi_titre']);

        

            }    
            catch (PDOException $e) {
                // en cas d'erreur, on récup et on affiche, grâce à notre try/catch
                exit("❌🙀💀 OOPS :\n" . $e->getMessage());
            }  
        }


    ?>
        <form action="modifier.php" method="POST" >
            <label for="name">Tape des trucs ma gueule !</label>
            <input type="text" name="titre" required>
            <input type="file" name="affiche" required>
            <input type="text" name="acteur" required>
            <input type="date" name="dateDeSortie" required>
            <input type="text" name="synopsis" required>
            <input type="text" name="realisateur" required>
            <input type="text" name="id" value="<?php echo($id);?>">
            <input type="submit" value="Aller go !">
        </form>    
    </body>
</html>