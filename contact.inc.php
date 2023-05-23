<?php
    // Démarrage ou restauration de la session
    session_start();
    if(isset($_SESSION['user'])){
        if($_SESSION['user-data'][2] !== "NULL") {
            $prenom = $_SESSION['user-data'][2];
		}
        if($_SESSION['user-data'][3] !== "NULL") {
            $nom = $_SESSION['user-data'][3];
		}
        if($_SESSION['user-data'][4] !== "NULL") {
            $dateDeNaissance = $_SESSION['user-data'][4];
		}
        if($_SESSION['user-data'][6] !== "NULL") {
            $email = $_SESSION['user-data'][6];
		}
    }
?>

<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/contact.css">
    <title>
        Boutique Street'N Chic | FRANCE
    </title>
    <script type= "text/javascript" src="js/contact.js"></script>
</head>

<body>
        <?php
            require "php/header.inc.php";
            require "php/aside.inc.php";
        ?>

        <main>
            <br>
            <?php if (isset($_SESSION['mail_sended'])) { ?>
            <div id="mail-sended">La demande de contact a bien était prise en compte.</div>
            <?php } ?>
            <?php if (isset($_SESSION['mail_failed'])) { ?>
            <div id="mail-failed">La demande de contact n'a pas pu être prise en compte. Veuillez essayer plus tard.</div>
            <?php } ?>
            <?php unset($_SESSION['mail_sended']); unset($_SESSION['mail_failed']); ?>
            <?php if ($messages_derreur !== '') { ?>
                <div id="contact-failed"> <?php print($messages_derreur); ?> </div>
            <?php } ?>
            <br>
            <h1>Formulaire de contact</h1>
            <br>
            <form method="POST" action="check_data_form.php" id="formulaireContact">
                <div class="style">
                    <label for="dateDuContact">Date du contact </label>
                    <input type="date" id="dateDuContact" oninput="return isDate('dateDuContact')" name="dateDuContact" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value="<?php echo $dateDuContact ?>" required>
                </div>

                <div class="style">
                    <label for="nom">Nom </label>
                    <input type="text" id="nom" name="nom" oninput="return isName('nom')" placeholder="Entrez votre nom" pattern="[A-Za-zÀ-ÿ][A-Za-zÀ-ÿ'-]*" value="<?php echo $nom ?>" required>
                </div>
                
                <div class="style">
                    <label for="prenom">Prénom </label>
                    <input type="text" id="prenom" name="prenom" oninput="return isName('prenom')" placeholder="Entrez votre prénom" pattern="[A-Za-zÀ-ÿ][A-Za-zÀ-ÿ'-]*" value="<?php echo $prenom ?>" required>
                </div>
                                
                <div class="style">
                    <label for="email">Email </label>
                    <input type="email" id="email" name="email" oninput="return isEmail('email')" placeholder="monmail@monsite.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="<?php echo $email ?>" required>
                </div>
                
                <br>
               
                    <p> Genre
                            <label for="femme">Femme </label>
                            <input type="radio" id="femme" name="genre" value="femme" <?php echo $genre_f ?> required/>
                        
                
                        
                            <label for="homme">Homme </label>
                            <input type="radio" id="homme" name="genre" value="homme" <?php echo $genre_h ?>/>
                    </p>
                <br>
                
                <div class="style">
                    <label for="dateDeNaissance">Date de naissance </label>
                    <input type="date" id="dateDeNaissance" oninput="return isDate('dateDeNaissance')" name="dateDeNaissance" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value="<?php echo $dateDeNaissance ?>" required>
                </div>
                
                <div class="style">
                    <label for="fonction-select">Fonction</label>

                    <select name="fonction" id="fonction-select">
                        <option value="sansActivite" <?php echo $choice[0] ?>>Sans activité professionnelle</option>
                        <option value="cadreFonctionPublique" <?php echo $choice[1] ?>>Cadre de la focntion publique</option>
                        <option value="candreEntreprise" <?php echo $choice[2] ?>>Cadre d'entreprise</option>
                        <option value="etudiant" <?php echo $choice[3] ?>>Etudiant</option>
                        <option value="enseignant" <?php echo $choice[4] ?>>Enseignant</option>
                        <option value="artisan" <?php echo $choice[5] ?>>Artisan</option>
                        <option value="technicien" <?php echo $choice[6] ?>>Technicien</option>
                        <option value="ouvrier" <?php echo $choice[7] ?>>Ouvrier</option>
                        <option value="agriculteur" <?php echo $choice[8] ?>>Agriculteur</option>
                        <option value="commercant" <?php echo $choice[9] ?>>Commerçant</option>
                        <option value="retraite" <?php echo $choice[10] ?>>Retraité</option>
                        <option value="nonRenseigne" <?php echo $choice[11] ?>>Non renseigné (inconnu)</option>
                    </select>
                </div>
                
                <div class="style">
                    <label for="sujetMail">Sujet : </label>
                    <input type="text" id="sujetMail" name="sujetMail" placeholder="Entrez le sujet de votre mail" value="<?php echo $sujetMail ?>" required>
                </div>
                
                <div class="style">
                    <label for="contenuMail">Contenu : </label>
                    <textarea name="contenu" id="contenuMail" placeholder="Tapez ici votre mail" required><?php echo $contenu ?></textarea>
                </div>
                
                <div class="button">
                    <input type="submit" value="Envoyer le formulaire">
                </div>
            </form>
            <br>
            <br>
        </main>

        <?php
            require "php/footer.inc.php";
        ?>
</body>
    
</html>