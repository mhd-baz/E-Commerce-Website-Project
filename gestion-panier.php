<?php
    session_start();
    include_once("fonctions-panier.php");
    if ($_SERVER['REQUEST_METHOD']=='POST'){
        $quantite = $_POST['quantite'];
        $description = $_POST['prodDescription'];
        $prix = $_POST['prodPrice'];
        $reference = $_POST['prodId'];
        $nomCategorie = $_POST['nomCategorie'];
        if($quantite > 0) {
            ajouterArticle($reference, $quantite, $prix);
        }
        $header = "Location: produits.php?cat=" . strtolower($nomCategorie);
        header($header);
        exit();
	}
?>