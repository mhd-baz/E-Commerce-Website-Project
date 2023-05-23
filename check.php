<?php
// (A) START SESSION 
session_start();
include 'bdd/bdd.php';
$_SESSION["users"] = getUsers();

if (isset($_POST['signeIn'])) {
    // (B) HANDLE LOGIN
    if (isset($_POST['user']) && !isset($_SESSION['user'])) {
        //print_r(($_SESSION["users"]));
        for ($i = 0 ; $i<count($_SESSION["users"]) ; $i++) {
            if ($_POST['user'] == $_SESSION["users"][$i][0]) {
                if (password_verify($_POST['password'], $_SESSION["users"][$i][1])) {
                    $_SESSION["users"][$i][5] = str_replace('+', " ", $_SESSION["users"][$i][5]);
                    $_SESSION['user'] = $_POST['user'];
                    $_SESSION['user-data'] = $_SESSION["users"][$i];
                    print_r($_SESSION['user-data']);
	            }
	        }
        }
        unset($_SESSION["users"]);

 

      // (B3) FAILED LOGIN FLAG
      if (!isset($_SESSION['user'])) { $failed_login = true; }
    }
 
    // (C) REDIRECT USER TO HOME PAGE IF SIGNED IN
    if (isset($_SESSION['user'])) {
        header("Location: index.php");
        exit();
    }
}
elseif (isset($_POST['inscription'])) {
    for ($i = 0 ; $i<count($_SESSION["users"]) ; $i++) {
        if ($_POST['user'] == $_SESSION["users"][$i][0]) {
            $failed_inscription = true;
        }
    }
    if (!isset($failed_inscription)) {
        if (connexion()) {
            $id_connexion = $_SESSION['id_connexion'];
            $query = "INSERT INTO users (username, password) VALUES ('" . $_POST['user'] . "', '" . password_hash($_POST['password'], PASSWORD_DEFAULT) . "')";
            if (($result = mysqli_query($id_connexion, $query))) {
                $success_inscirption = true;
            }
            deconnexion();
            unset($_SESSION['id_connexion']);
	    }
    }
}
?>