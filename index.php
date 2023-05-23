<?php
    // Démarrage ou restauration de la session
    session_start();
    include 'bdd/bdd.php';
    $_SESSION["categories"] = getCategories();
?>

<html>

<head>
    <meta charset="utf-16">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/index.css">
    <title>
        Boutique Street'N Chic | FRANCE
    </title>
</head>

<body>
        <?php
            require "php/header.inc.php";
            require "php/aside.inc.php";
        ?>

        <main>
            <br>
            <?php if (isset($_SESSION['user']) && !isset($_SESSION['flagConnexion'])) { ?>
                <div id="connected">Vous êtes désormais connecté !</div>
                <?php $_SESSION['flagConnexion'] = TRUE; ?>
            <?php } ?>
            <br>
            <h1>"Chic et à la mode avec Street'N Chic"</h1>
            <br>
            <br>
            <img src="img/logo.jpg" width="400" />
            <br>
            <br>
            <br>
            <p> Appelez notre service commercial au 01.96.97.98.99 pour recevoir un bon de commande.</p>
            <br>
            <br>
            <br>
        </main>

        <?php
            require "php/footer.inc.php";
        ?>
    
</body>
    
</html>