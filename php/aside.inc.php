        <aside>
            <h3>Boutique Street'N Chic</h3>
            <br>
            <h4> <a href="index.php">Accueil</a></h4>
            <br>
            <hr>
            <br>
            <h4><u>Nos Produits</u></h4>
            <br>
            
            <ul id="asideList">
                <?php
                    include_once "php/varSession.inc.php";
                    for ($i=0; $i<count($_SESSION["categories"]); $i++) {
                        $nom_categorie = $_SESSION["categories"][$i];
                        $lien_categorie = "produits.php?cat=" . strtolower($nom_categorie);
                        echo "<li> <a href=$lien_categorie> $nom_categorie </a> </li>";
					}
                ?>
                <li> <br> </li>
                <li> <a href="contact.php"> Contact </a> </li>
            </ul>
        </aside>