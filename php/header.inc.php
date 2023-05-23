   <?php

   ?>
   
   <header>
            <div id="titre">
                <h1> Boutique Street'N Chic </h1>
            </div>
            
            <div id="logo">
                <a href="index.php"> <img src="img/logo.jpg" width="150" /> </a>
            </div>
            
            <nav>
                <ul>
                    <li id="acceuil"> <a href="index.php"> Accueil </a> </li>
                    <?php
                        include_once "php/varSession.inc.php";
                        for ($i=0; $i<count($_SESSION["categories"]); $i++) {
                            $nom_categorie = $_SESSION["categories"][$i];
                            $nom_categorie_min = strtolower($nom_categorie);
                            $lien_categorie = "produits.php?cat=" . $nom_categorie_min;
                            echo "<li id=$nom_categorie_min> <a href=$lien_categorie> $nom_categorie </a> </li>";
					    }
                    ?>
                    <li id="contact"> <a href="contact.php"> Contact </a> </li>
                </ul>
            </nav>
                
                <div id = connexion>
                    <ul>
                    <li id="panier"><a href="panier.php"> Panier </a></li>

                    <?php if (isset($_SESSION['user'])) { ?>
                        <li> <?php print($_SESSION['user']) ?>
                            <ul>
                                <?php if ($_SESSION['user'] !== "admin") { ?>
                                    <li> <a href="espace-client.php"> Mon espace client </a></li>
                                <?php } ?>
                                <li> <a href="deconnexion.php"> Deconnexion </a> </li>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if (!isset($_SESSION['user'])) { ?>
                        <li><a href="connexion.php"> Connexion </a></li>
                    <?php } ?>
                    </ul>
                </div>

        </header>