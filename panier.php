<?php
session_start();
include_once("fonctions-panier.php");
include 'bdd/bdd.php';
$_SESSION["categories"] = getCategories();

$erreur = false;

$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
if($action !== null)
{
   if(!in_array($action,array('ajout', 'suppression', 'refresh')))
   $erreur=true;

   //récupération des variables en POST ou GET
   $l = (isset($_POST['l'])? $_POST['l']:  (isset($_GET['l'])? $_GET['l']:null )) ;
   $p = (isset($_POST['p'])? $_POST['p']:  (isset($_GET['p'])? $_GET['p']:null )) ;
   $q = (isset($_POST['q'])? $_POST['q']:  (isset($_GET['q'])? $_GET['q']:null )) ;

   //Suppression des espaces verticaux
   $l = preg_replace('#\v#', '',$l);
   //On vérifie que $p est un float
   $p = floatval($p);

   //On traite $q qui peut être un entier simple ou un tableau d'entiers
    
   if (is_array($q)){
      $QteArticle = array();
      $i=0;
      foreach ($q as $contenu){
         $QteArticle[$i++] = intval($contenu);
      }
   }
   else
   $q = intval($q);
    
}

if (!$erreur){
   switch($action){
      Case "ajout":
         ajouterArticle($l,$q,$p);
         break;

      Case "suppression":
         supprimerArticle($l);
         break;

      Case "refresh" :
         for ($i = 0 ; $i < count($QteArticle) ; $i++)
         {
            modifierQTeArticle($_SESSION['panier']['libelleProduit'][$i],round($QteArticle[$i]));
         }
         break;

      Default:
         break;
   }
}
?>

<html>

<head>
    <meta charset="utf-16">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/produits.css">
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
            <div id="succes-commande">Votre commande a bien été validée !</div>
            
            <form method="post" action="panier.php">
            <table id="table" style="width: 400px">
                <tr>
                    <td colspan="5">Votre panier</td>
                </tr>
                <tr>
                    <td>Aperçu</td>
                    <td>Libellé</td>
                    <td>Quantité</td>
                    <td>Prix Unitaire</td>
                    <td>Total produit</td>
                    <td>Action</td>
                </tr>
                <?php
                if (creationPanier())
                {
                    $nbArticles=count($_SESSION['panier']['libelleProduit']);
                    
                    if ($nbArticles <= 0)
                    echo "<tr><td colspan=\"2\"><b>Votre panier est vide <b></ td></tr>";
                    else
                    {
                        for ($i=0 ;$i < $nbArticles ; $i++)
                        {   
                            echo "<tr>";
                            echo "<td width=20%><img src=\"".htmlspecialchars($_SESSION['panier']['image'][$i])."\"width=\"100\" /></td>";
                            echo "<td id=" . $_SESSION['panier']['libelleProduit'][$i] . ".>".htmlspecialchars($_SESSION['panier']['libelleProduit'][$i])."</ td>";
                            echo "<td><input type=\"text\" size=\"4\" name=\"q[]\" value=\"".htmlspecialchars($_SESSION['panier']['qteProduit'][$i])."\"/></td>";
                            echo "<td>".htmlspecialchars($_SESSION['panier']['prixProduit'][$i])."€</td>";
                            echo "<td>".htmlspecialchars($_SESSION['panier']['prixProduit'][$i]*$_SESSION['panier']['qteProduit'][$i])."€</td>";
                            echo "<td><a href=\"".htmlspecialchars("panier.php?action=suppression&l=".rawurlencode($_SESSION['panier']['libelleProduit'][$i]))."\">Enlever</a></td>";
                            echo "</tr>";
                        }

                        echo "<tr><td colspan=\"2\"> </td>";
                        echo "<td colspan=\"3\">";
                        echo "Total : ".MontantGlobal()."€";
                        echo "</td></tr>";

                        echo "<tr><td colspan=\"5\">";
                        echo "<input type=\"submit\" value=\"Actualiser\"/>";
                        echo "<input type=\"hidden\" name=\"action\" value=\"refresh\"/>";

                        echo "</td></tr>";

                    }
                    
                }

                ?>
            </table>
            <br>

            <script>
                function commander(){
                    var panier_ref = new Array();
                    var panier_quantite = new Array();
                    <?php
                    $nbArt = count($_SESSION['panier']['libelleProduit']);
                    for ($i=0; $i < $nbArt ; $i++) { ?>
                        panier_ref.push(<?php echo "'" .($_SESSION['panier']['libelleProduit'][$i]) . "'"; ?>);
                        panier_quantite.push(<?php echo "'" .($_SESSION['panier']['qteProduit'][$i]) . "'"; ?>);
                    <?php } ?>
	                var xhttp = new XMLHttpRequest();
	                xhttp.onreadystatechange = function() {
		                if (this.readyState == 4 && this.status == 200) {
                            var Table = document.getElementById('table');
                            Table.innerHTML = "<tr> <td colspan='5'>Votre panier</td> </tr> <tr> <td>Aperçu</td> <td>Libellé</td> <td>Quantité</td> <td>Prix Unitaire</td> <td>Total produit</td> <td>Action</td><tr><tr><td colspan=\"2\"><b>Votre panier est vide <b></ td></tr>";
			                var BoutonCommander = document.getElementById('commander');
                            BoutonCommander.innerHTML = "";
                            var TextMessage = document.getElementById('succes-commande');
                            TextMessage.style.visibility ="visible";
		                }
	                };
	                xhttp.open("GET", "validationCommande.php?ref="+panier_ref+"&qt="+panier_quantite, true);
	                xhttp.send(null);
                    return false;
                }
            </script>
            <?php if ($nbArticles > 0) { ?>
                <div id='commander'>
                    <input type="button" value="Commander" onclick="return commander()"/>
                </div>
            <?php } ?>
            </form>
            <br>
            <br>
        </main>

        <?php
            require "php/footer.inc.php";
        ?>
    
</body>
    
</html>

