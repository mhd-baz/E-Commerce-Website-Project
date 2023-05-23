<?php
    session_start();
    include 'bdd/bdd.php';
    $_SESSION["categories"] = getCategories();
    $_SESSION["produits"] = getProduits();

	$indice = -1;
	for ($i=0; $i<count($_SESSION["categories"]); $i++) {
		if (strtolower($_SESSION["categories"][$i]) == $_GET['cat']) {
			$indice = $i;
		}
	}
?>

<html>

    <?php
        $nom_categorie = $_GET['cat'];
        echo "<style>#$nom_categorie a:link, #$nom_categorie a:visited {
            color: white;
            background: black;
        }</style>"
    ?>

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/produits.css">
        <title>
            Boutique Street'N Chic | FRANCE
        </title>
        <script type= "text/javascript" src="js/produits.js"></script>
    </head>

    <body>
        <?php
            require "php/header.inc.php";
            require "php/aside.inc.php";
        ?>

        <main>
            <br>
            <?php if (isset($_SESSION['ajout_failed'])) { ?>
                <div id="ajout-failed">Article(s) non ajouté(s) au panier car le stock est insuffisant.</div>
            <?php } ?>
            <?php if (isset($_SESSION['ajout_success'])) { ?>
                <div id="ajout-success">Article(s) ajouté(s) au panier avec succès !</div>
            <?php } ?>
            <?php if (isset($_SESSION['ajout_medium'])) { ?>
                <div id="ajout-medium">Attention, seulement <?php print($_SESSION['ajout_medium']) ?> article(s) ont été ajouté(s) au panier car le stock est insuffisant !</div>
            <?php } ?>
            <?php  unset($_SESSION['ajout_failed']); unset($_SESSION['ajout_success']); unset($_SESSION['ajout_medium']); ?>
            <br>
            <br>
            <?php
                $nom_categorie = $_SESSION["categories"][$indice];
                echo "<h1>$nom_categorie </h1>";
            ?>
            <br>
            <table>
                <?php
                   for($i=0; $i<count($_SESSION["produits"][$indice]); $i++) {

                        $product_id = $_SESSION["produits"][$indice][$i][0];
                        $product_description = $_SESSION["produits"][$indice][$i][1];
                        $product_price = $_SESSION["produits"][$indice][$i][2] . "€";
                        $product_price_bis = $_SESSION["produits"][$indice][$i][2];
                        $product_stock_id = "stock_" . $product_id;
                        $product_stock_value = $_SESSION["produits"][$indice][$i][3] . " en stock";
                        $img_link = "img/" . $product_id . ".jpg";

                        $button_enlever_id = "enlever_" . $product_id;
                        $button_ajouter_id = "ajouter_" . $product_id;
                        $text_quantite_id = "quantite_" . $product_id;

                        echo "<tr>
                                <td width=20%><img src=$img_link width=\"150\" /></td>
                                <td>$product_id</td>
                                <td>$product_description</td>
                                <td>$product_price</td> 
                                <td class=\"stock\" id=$product_stock_id>$product_stock_value</td>
                                <td>
                                    <form method=\"POST\" action=\"gestion-panier.php\">
                                        <input type=\"button\" id=$button_enlever_id onClick=\"substract('$text_quantite_id', '$button_ajouter_id', '$button_enlever_id');\" value =\"-\" disabled=\"disabled\">
                                        <input type=\"text\" name=\"quantite\" value=\"0\" id=$text_quantite_id size=\"2\" readonly> 
                                        <input type=\"button\" id=$button_ajouter_id onClick=\"add('$text_quantite_id', '$product_stock_id', '$button_ajouter_id', '$button_enlever_id');\" value = \"+\">
                                        <br>
                                        <br>
                                        <input name=\"prodId\" type=\"hidden\" value=\"$product_id\">
                                        <input name=\"prodPrice\" type=\"hidden\" value=\"$product_price_bis\">
                                        <input name=\"prodDescription\" type=\"hidden\" value=\"$product_description\">
                                        <input name=\"nomCategorie\" type=\"hidden\" value=\"$nom_categorie\">
                                        <input type=\"submit\" value=\"Ajouter au panier\">
                                    </form>
                                </td>
                             </tr>";
				   }
                ?>
            </table>
            <br>
            <?php if ((isset($_SESSION['user'])) && ($_SESSION['user'] === "admin")) { ?>
                <button type="button" id="fctCacher" onclick="cacherStcok('stock');"> Afficher Stock </button>
            <?php } ?>
            <br>
            <br>
        </main>

        <?php
            require "php/footer.inc.php";
        ?>
    
    </body>
    
</html>