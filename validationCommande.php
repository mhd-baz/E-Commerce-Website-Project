<?php
	session_start();
	include 'bdd/bdd.php';

	$panier_ref = explode(",", $_GET['ref']);
	$panier_quantite = explode(",", $_GET['qt']);

    if (connexion()) {
		$id_connexion = $_SESSION['id_connexion'];
		for ($i = 0; $i<count($panier_ref); $i++) {
			$query1 = "SELECT stock FROM produits WHERE reference = '". $panier_ref[$i] . "'";
			if (($result1 = mysqli_query($id_connexion, $query1))) {
				$row = mysqli_fetch_row($result1);
				$newStock = $row[0] - $panier_quantite[$i];
			}
			mysqli_free_result( $result1 );

			$query2 = "UPDATE produits SET stock='".$newStock."' WHERE reference = '". $panier_ref[$i] . "'";
			if (($result2 = mysqli_query($id_connexion, $query2))) {}
		}
		deconnexion();
		unset($_SESSION['id_connexion']);
		echo "Votre commande a bien été validée !";
	}

	unset($_SESSION['panier']);
?>
