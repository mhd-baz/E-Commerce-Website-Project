<?php
function connexion() {
    include 'bddData.php';

    // Connexion à mysql
	if ( ! ($id_connexion = mysqli_connect($host, $user, $password)) ) {
	    return false;
        exit;
	}
    // Connexion à la base
	if ( ! mysqli_select_db( $id_connexion, $db)) {
        return false;
        exit;
    }
    else {
        $_SESSION['id_connexion'] = $id_connexion;
        return true;
    }
}

function deconnexion() {
    // Déconnexion de la base de données
    mysqli_close($_SESSION['id_connexion']);
}

function getCategories() {
    if(connexion()) {
        $id_connexion = $_SESSION['id_connexion'];  
        $query = "SELECT nom_categorie FROM categories";
        if ( ! ($result = mysqli_query($id_connexion, $query))) {
            return NULL;
        } 
        else {
            // Recuperation des résultats
            while ($row = mysqli_fetch_row($result)) {
                $categories[] = $row[0];
            }
            return $categories;
        }
        mysqli_free_result( $result );
        deconnexion();
        unset($_SESSION['id_connexion']);
    }
}

function getProduits() {
    if(connexion()) {
        $id_connexion = $_SESSION['id_connexion'];
        for ($i=0 ; $i<count($_SESSION["categories"]) ; $i++ ) {
            $query = "SELECT * FROM produits WHERE produits.nom_categorie = '" . $_SESSION["categories"][$i] ."'";
            if ( ! ($result = mysqli_query($id_connexion, $query))) {
                return NULL;
            } 
            else {
                // Recuperation des résultats
                while ($row = mysqli_fetch_row($result)) {
                    $temp[] = $row[1];
                    $temp[] = $row[2];
                    $temp[] = $row[3];
                    $temp[] = $row[4];
                    $cat_produits[] = $temp;
                    unset($temp);
                }
            }
            $produits[] = $cat_produits;
            unset($cat_produits);
        }
        return $produits;
        mysqli_free_result( $result );
        deconnexion();
        unset($_SESSION['id_connexion']);
    }
}


function getUsers() {
    if(connexion()) {
        $id_connexion = $_SESSION['id_connexion'];  
        $query = "SELECT * FROM users";
        if ( ! ($result = mysqli_query($id_connexion, $query))) {
            return NULL;
        } 
        else {
            // Recuperation des résultats
            while ($row = mysqli_fetch_row($result)) {
                $users[] = $row;
            }
            return $users;
        }
        mysqli_free_result( $result );
        deconnexion();
        unset($_SESSION['id_connexion']);
    }
}
?>