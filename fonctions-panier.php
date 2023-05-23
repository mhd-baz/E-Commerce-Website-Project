<?php

/**
 * Verifie si le panier existe, le crée sinon
 * @return booleen
 */
function creationPanier(){
   if (!isset($_SESSION['panier'])){
      $_SESSION['panier']=array();
      $_SESSION['panier']['image'] = array();
      $_SESSION['panier']['libelleProduit'] = array();
      $_SESSION['panier']['qteProduit'] = array();
      $_SESSION['panier']['prixProduit'] = array();
      $_SESSION['panier']['verrou'] = false;
   }
   return true;
}

function renvoiePoistion($libelleProduit) {
    $categorie = -1;
    $position = -1;
    for ($i=0; $i<count($_SESSION['produits']); $i++) {
        for($j=0; $j<count($_SESSION['produits'][$i]); $j++) {
            if ($_SESSION['produits'][$i][$j][0] == $libelleProduit){
                $categorie = $i;
                $position = $j;
			}
		}
	}
    return array($categorie, $position);
}

function renvoieStockMax($libelleProduit) {
    $positionProduit = renvoiePoistion($libelleProduit);
    $quantiteMaxStock = $_SESSION['produits'][$positionProduit[0]][$positionProduit[1]][3];
    return $quantiteMaxStock;
}
/**
 * Ajoute un article dans le panier
 * @param string $libelleProduit
 * @param int $qteProduit
 * @param float $prixProduit
 * @return void
 */
function ajouterArticle($libelleProduit,$qteProduit,$prixProduit){

   //Si le panier existe
   if (creationPanier() && !isVerrouille())
   {
      //Si le produit existe déjà on ajoute seulement la quantité

      $positionProduit = array_search($libelleProduit,  $_SESSION['panier']['libelleProduit']);
      $quantite_max_stock = renvoieStockMax($libelleProduit);
      print($positionProduit);
      if ($positionProduit !== FALSE)
      {
         $quantiteSuppAutorise = $quantite_max_stock -  $_SESSION['panier']['qteProduit'][$positionProduit];
         $qte = min($qteProduit, $quantiteSuppAutorise);
         $_SESSION['panier']['qteProduit'][$positionProduit] += $qte ;
         if($quantiteSuppAutorise == 0) {$_SESSION['ajout_failed'] = TRUE;} elseif ($qte == $qteProduit) {$_SESSION['ajout_success'] = TRUE;} else {$_SESSION['ajout_medium'] = $quantiteSuppAutorise;}
      }
      else
      {
         $qte = min($qteProduit, $quantite_max_stock);
         //Sinon on ajoute le produit  
         array_push( $_SESSION['panier']['image'],"img/".$libelleProduit.".jpg");
         array_push( $_SESSION['panier']['libelleProduit'],$libelleProduit);
         array_push( $_SESSION['panier']['qteProduit'],$qte);
         array_push( $_SESSION['panier']['prixProduit'],$prixProduit);
         if ($qte == $qteProduit) {$_SESSION['ajout_success'] = TRUE;} else {$_SESSION['ajout_medium'] = $quantite_max_stock;}
      }
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}



/**
 * Modifie la quantité d'un article
 * @param $libelleProduit
 * @param $qteProduit
 * @return void
 */
function modifierQTeArticle($libelleProduit,$qteProduit){
   //Si le panier existe
   if (creationPanier() && !isVerrouille())
   {
      //Si la quantité est positive on modifie sinon on supprime l'article
      if ($qteProduit > 0)
      {
         $qteProduit = min($qteProduit, renvoieStockMax($libelleProduit));
         //Recharche du produit dans le panier
         $positionProduit = array_search($libelleProduit,  $_SESSION['panier']['libelleProduit']);

         if ($positionProduit !== false)
         {
            $_SESSION['panier']['qteProduit'][$positionProduit] = $qteProduit ;
         }
      }
      else {
        supprimerArticle($libelleProduit);
      }
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}

/**
 * Supprime un article du panier
 * @param $libelleProduit
 * @return unknown_type
 */
function supprimerArticle($libelleProduit){
   //Si le panier existe
   if (creationPanier() && !isVerrouille())
   {
      //Nous allons passer par un panier temporaire
      $tmp=array();
      $tmp['image'] = array();
      $tmp['libelleProduit'] = array();
      $tmp['qteProduit'] = array();
      $tmp['prixProduit'] = array();
      $tmp['verrou'] = $_SESSION['panier']['verrou'];

      for($i = 0; $i < count($_SESSION['panier']['libelleProduit']); $i++)
      {
         if ($_SESSION['panier']['libelleProduit'][$i] !== $libelleProduit)
         {
            array_push( $tmp['image'],$_SESSION['panier']['image'][$i]);
            array_push( $tmp['libelleProduit'],$_SESSION['panier']['libelleProduit'][$i]);
            array_push( $tmp['qteProduit'],$_SESSION['panier']['qteProduit'][$i]);
            array_push( $tmp['prixProduit'],$_SESSION['panier']['prixProduit'][$i]);
         }

      }
      //On remplace le panier en session par notre panier temporaire à jour
      $_SESSION['panier'] =  $tmp;
      //On efface notre panier temporaire
      unset($tmp);
   }
   else
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}


/**
 * Montant total du panier
 * @return int
 */
function MontantGlobal(){
   $total=0;
   for($i = 0; $i < count($_SESSION['panier']['libelleProduit']); $i++)
   {
      $total += $_SESSION['panier']['qteProduit'][$i] * $_SESSION['panier']['prixProduit'][$i];
   }
   return $total;
}


/**
 * Fonction de suppression du panier
 * @return void
 */
function supprimePanier(){
   unset($_SESSION['panier']);
}

/**
 * Permet de savoir si le panier est verrouillé
 * @return booleen
 */
function isVerrouille(){
   if (isset($_SESSION['panier']) && $_SESSION['panier']['verrou'])
   return true;
   else
   return false;
}

/**
 * Compte le nombre d'articles différents dans le panier
 * @return int
 */
function compterArticles()
{
   if (isset($_SESSION['panier']))
   return count($_SESSION['panier']['libelleProduit']);
   else
   return 0;

}

?>