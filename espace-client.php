<?php
    session_start();
    $prenom_afficher = $_SESSION['user-data'][2];
    $nom_afficher = $_SESSION['user-data'][3];
    $date_afficher = $_SESSION['user-data'][4];
    $adress_afficher = $_SESSION['user-data'][5];
    $email_afficher = $_SESSION['user-data'][6];
    $phone_afficher = $_SESSION['user-data'][7];
    require "espace-client-gestion.php";
?>

<html>

<head>
    <meta charset="utf-16">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/espace-client.css">
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
            
            <?php if (isset($username_invalid)) { ?>
                <div id="modification-failed"> Le nom d'utilisateur ne doit pas contenir d'espace. Veuillez en choisir un autre.</div>
            <?php } ?>

            <?php if ((isset($modification_succes)) && (isset($username_invalid))) { ?>
                <div id="modification-success">Le reste de vos données personnelles ont été mises à jour avec succès !</div>
            <?php } ?>

            <?php if (isset($user_available)) { ?>
                <div id="modification-failed"> Ce nom d'utilisateur est indisponible. Veuillez en choisir un autre.</div>
            <?php } ?>

            <?php if (isset($afficher_message_avertissement)) { ?>
                <div id="modification-medium"> <?php print($messages_derreur) ?></div>
            <?php } ?>

            <?php if ((isset($modification_succes)) && (!isset($username_invalid))) { ?>
                <div id="modification-success">Vos données personnelles ont été mises à jour avec succès !</div>
            <?php } ?>

            <?php if (!isset($password_failure)) { ?>
                <div id="modification-failed">Votre mot de passe est inccorect</div>
            <?php } ?>

            <?php if (!isset($password_succes) && isset($password_failure)) { ?>
                <div id="modification-failed">Votre nouveau mot de passe et sa confirmation ne sont pas identiques. Veuillez réasseyer</div>
            <?php } ?>

            <?php if (isset($password_succes) && ($password_succes === TRUE)) { ?>
                <div id="modification-success">Votre mot de passe a été changé avec succès !</div>
            <?php } ?>

            <br>
            <div id="test">
            <?php if (!isset($change_password) && !isset($delete_account)) { ?>
                <h1>Bienvenue dans votre espace client <?php if ($_SESSION['user-data'][2] !== "NULL") { print($_SESSION['user-data'][2] ." !"); } ?></h1>
                <br>
                <br>
                <h2> <u> Vos données personelles : </u> </h2>
                <br>
                <form method="post" target="_self">
                <table>
                    <tr>
                        <td><h3> Votre nom d'utilisateur : </h3> </td>
                        <td colspan=0> <input type='text' id='user' name='user'  value="<?php print($_SESSION['user']) ?>" <?php if (!isset($allow_modification)) {print('readonly');}?> required /> </td>
                    </tr>
                    <tr>
                        <td><h3> Votre prénom : </h3> </td>
                        <td colspan=0> <input type='text' id='prenom' name='prenom' oninput="return isName('prenom')" value="<?php if ($prenom_afficher !== "NULL") { print($prenom_afficher); } elseif (!isset($allow_modification)) { print('Non renseignée'); } ?>"  <?php if (!isset($allow_modification)) {print('readonly');}?> /> </td>
                    </tr>
                    <tr>
                        <td><h3> Votre nom : </h3> </td>
                        <td colspan=0> <input type='text' id='nom' name='nom' oninput="return isName('nom')" value="<?php if ($nom_afficher !== "NULL") { print($nom_afficher); } elseif (!isset($allow_modification)) { print('Non renseignée'); } ?>" <?php if (!isset($allow_modification)) {print('readonly');}?> /> </td>
                    </tr>
                    <tr>
                        <td><h3> Votre date de naissance : </h3> </td>
                        <td colspan=0> <input type='date' id='date' name='date' oninput="return isDate('date')" value="<?php if ($date_afficher !== "NULL") { print($date_afficher); } elseif (!isset($allow_modification)) { print(''); } ?>" <?php if (!isset($allow_modification)) {print('readonly');}?>/> </td>
                    </tr>
                    <tr>
                        <td><h3> Votre adresse : </h3> </td>
                        <td colspan=0> <input type='text' id='adress' name='adress' value="<?php if ($adress_afficher !== "NULL") { print($adress_afficher); } elseif (!isset($allow_modification)) { print('Non renseignée'); } ?>" <?php if (!isset($allow_modification)) {print('readonly');}?> /> </td>
                    </tr>
                    <tr>
                        <td><h3> Votre adresse mail : </h3> </td>
                        <td colspan=0>  <input type='text' id="email" name="email" oninput="return isEmail('email')" value="<?php if ($email_afficher !== "NULL") { print($email_afficher); } elseif (!isset($allow_modification)) { print('Non renseignée'); } ?>" <?php if (!isset($allow_modification)) {print('readonly');}?> /> </td>
                    </tr>
                    <tr>
                        <td><h3> Votre numéro de téléphone : </h3> </td>
                        <td colspan=0> <input type='text' id='phone' name="phone" oninput="return isNumber('phone')" value="<?php if ($phone_afficher !== "NULL") { print($phone_afficher); } elseif (!isset($allow_modification)) { print('Non renseignée'); } ?>" <?php if (!isset($allow_modification)) {print('readonly');}?> /> </td>
                    </tr>
                </table>
                <br>
                <br>
                <?php if (!isset($allow_modification)) { ?>
                    <input type="submit" name="modifier" style="font-weight: bold;" value="Modifier vos données" />
                    <input type="submit" name="changerMDP" style="font-weight: bold;" value="Changer de mot de passe" />
                    <input type="submit" name="supprimerCompte" style="font-weight: bold;" value="Supprimer votre compte" />
                <?php } ?>
                <?php if (isset($allow_modification)) { ?>
                    <input type="submit" name="valider-modif" style="font-weight: bold;" value="Valider" />
                    <a href="espace-client.php" > <input type="button" name="back" style="font-weight: bold;" value="Annuler" /> </a>
                <?php } ?>
                </form>
            <?php } elseif (!isset($delete_account)) { ?>
               <h1>Bienvenue dans votre espace client <?php if ($_SESSION['user-data'][2] !== "NULL") { print($_SESSION['user-data'][2] ." !"); } ?></h1>
               <br>
               <br>
               <br>
               <h2> <u> Changer de mot de passe : </u> </h2>
               <br>
               <br>
               <form method="post" target="_self">
               <table>
                    <tr>
                        <td><h3> Entrez votre mot de passe actuel : </h3> </td>
                        <td colspan=0> <input type='password' id='old_password' name='old_password' required /> </td>
                    </tr>
                    <tr>
                        <td><h3> Entrez votre nouveau mot de passe : </h3> </td>
                        <td colspan=0>  <input type='password' id="new_password" name="new_password" required /> </td>
                    </tr>
                    <tr>
                        <td><h3> Confirmez votre nouveau mot de passe : </h3> </td>
                        <td colspan=0> <input type='password' id='confirm_password' name="confirm_password" oninput="return isSamePassword('new_password', 'confirm_password')" required /> </td>
                    </tr>
               </table>
               <br>
               <br>
               <br>
                    <input type="submit" name="valider-password" style="font-weight: bold;" value="Valider" />
                    <a href="espace-client.php" > <input type="button" name="back" style="font-weight: bold;" value="Annuler" /> </a>
               </form>
            <?php } else { ?>
               <br>
               <h1> <u> SUPPRESSION DU COMPTE </u> </h1>
               <br>
               <br>
               <br>
               <br>
               <br>
               <h1> Êtes-vous sûr de vouloir supprimer votre compte? Il sera ensuite impossible de le récupérer. </h1>
               <br>
               <br>
               <br>
               <br>
               <br>
               <form  method="post" target="_self">
                    <input type="submit" name="confirm-delete" style="font-weight: bold;" value="Confirmer la suppression" />
               </form>
               <br>
               <br>
               <a href="espace-client.php" > <input type="button" name="back" style="font-weight: bold;" value="Annuler" /> </a>
               <br>
               <h1> </h1>
            <?php } ?>
            </div>
            <br>
            <br>
        </main>

        <?php
            require "php/footer.inc.php";
        ?>
    
</body>
    
</html>