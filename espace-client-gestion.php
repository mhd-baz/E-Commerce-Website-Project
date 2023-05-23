<?php
// (A) START SESSION 
	//session_start();
	include 'bdd/bdd.php';

	function valide_pre_nom($donnee) {
		return (preg_match("#^[A-Za-zÀ-ÿ]+[A-Za-zÀ-ÿ'-]*$#",$donnee));
	}

	function valide_user($user) {
		return (preg_match("#^[^\s]*$#",$user));
	}

    function valide_email($mail) {
		return (preg_match("#^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$#",$mail)); 
	}

	function valide_date($date) {
		$valide = TRUE;

        if (!preg_match("#^([0-9]{4})\-[0-9]{1,2}\-[0-9]{1,2}$#",$date)) {
			$valide = FALSE;
		}
        $orderdate = explode('-', $date);
        $year = (int) $orderdate[0];  
        $month = (int) $orderdate[1];
        $day = (int) $orderdate[2];

        if (!checkdate($month, $day, $year)) {
			$valide = FALSE;
		}

        $date_jour = date("Y-m-d");

        if ($date > $date_jour) {
			$valide = FALSE;
		}

		return $valide;
	}

	function valide_number($number) {
		return (preg_match("#^(01|02|03|04|05|06|07|08|09)[0-9]{8}$#",$number));
	}

	$password_failure = TRUE;
	$password_succes = FALSE;

	//CODE QUI PERMET D'ACTIVER LE MODE MODIFICATION
	if (isset($_POST['modifier'])) {
		$allow_modification = TRUE;
	}
	// CODE QUI PERMET DE METTRE A JOUR LES DONNES
	elseif (isset($_POST['valider-modif'])){
		
		echo '<style> #user #prenom, #nom, #date, #email, #phone, #user { background-color: white; } </style>';
		$messages_derreur = "ATTENTION CERTAINS ELEMENTS N'ONT PAS ETE ENREGISTRE CAR : <br>";

		if (empty($_POST['prenom'])) {$_POST['prenom'] = "NULL"; $prenom_afficher = "NULL";} elseif (!valide_pre_nom($_POST['prenom'])) {
			$prenom_afficher = $_POST['prenom'];
			$_POST['prenom'] = $_SESSION['user-data'][2];
			$afficher_message_avertissement = TRUE;
			$messages_derreur .= "Le prénom ne doit pas comporter de caractères spéciaux et/ou d'espaces." . "<br>";
			echo '<style> #prenom {background-color: red; }</style>';
		} else {$prenom_afficher = $_POST['prenom'];}

		if (empty($_POST['nom'])) {$_POST['nom'] = "NULL"; $nom_afficher = "NULL";} elseif (!valide_pre_nom($_POST['nom'])) {
			$nom_afficher = $_POST['nom'];
			$_POST['nom'] = $_SESSION['user-data'][3];
			$afficher_message_avertissement = TRUE;
			$messages_derreur .= "Le nom ne doit pas comporter de caractères spéciaux et/ou d'espaces." . "<br>";
			echo '<style> #nom {background-color: red; }</style>';
		} else {$nom_afficher = $_POST['nom'];}

		if (empty($_POST['date'])) {$_POST['date'] = "NULL"; $date_afficher = "NULL";} elseif (!valide_date($_POST['date'])) {
			$date_afficher = $_POST['date'];
			$_POST['date'] = $_SESSION['user-data'][4];
			$afficher_message_avertissement = TRUE;
			$messages_derreur .= "Vérifier la validité de la date de naissance, de plus elle doit être inférieure ou égale à celle du jour." . "<br>";
			echo '<style> #date {background-color: red; }</style>';
		} else {$date_afficher = $_POST['date'];}

		if (empty($_POST['adress'])) {$_POST['adress'] = "NULL"; $adress_afficher = "NULL";} else {$adress_afficher = $_POST['adress'];}

		if (empty($_POST['email'])) {$_POST['email'] = "NULL"; $email_afficher = "NULL";} elseif (!valide_email($_POST['email'])) {
			$email_afficher = $_POST['email'];
			$_POST['email'] = $_SESSION['user-data'][6];
			$afficher_message_avertissement = TRUE;
			$messages_derreur .= "Le mail doit être du format <i> [chaine_de_caractères]@[domaine].[extension_de_2_à_4_lettres] </i>" . "<br>";
			echo '<style> #email {background-color: red; }</style>';
		} else {$email_afficher = $_POST['email'];}

		if (empty($_POST['phone'])) {$_POST['phone'] = "NULL"; $phone_afficher = "NULL";} elseif (!valide_number($_POST['phone'])) {
			$phone_afficher = $_POST['phone'];
			$_POST['phone'] = $_SESSION['user-data'][7];
			$afficher_message_avertissement = TRUE;
			$messages_derreur .= "Le numéro de télphone doit être composé de 10 chiffres avec pour premier chiffre 0." . "<br>";
			echo '<style> #phone {background-color: red; }</style>';
		} else {$phone_afficher = $_POST['phone'];}

		//VERIFICATION pour savoir s'il y a des doublons ou pas pour l'utilisateur
		if ($_SESSION['user'] !== $_POST['user']) {
		    if (connexion()) {
				$id_connexion = $_SESSION['id_connexion'];
				$query = "SELECT username FROM users WHERE username = '". $_POST['user'] . "'";
				if (($result = mysqli_query($id_connexion, $query))) {
					$row = mysqli_fetch_row($result);
					if($row != NULL) {
						$user_available = FALSE;
					}
				}
				mysqli_free_result( $result );
				deconnexion();
				unset($_SESSION['id_connexion']);
			}
		}

		//SI LE USERNAME VOULU EST DISPONIBLE
		if (!isset($user_available)) {
			//Si le username contient des espaces
			if (!valide_user($_POST['user'])) {
				echo '<style> #user {background-color: red; }</style>';
				$username_invalid = TRUE;
				$_POST['user'] = $_SESSION['user'];
				$allow_modification = TRUE;
			}
			//Sinon
			else {
				$_SESSION['user-data'][0] = $_POST['user'];
			}

			$_SESSION['user-data'][2] = $_POST['prenom'];
			$_SESSION['user-data'][3] = $_POST['nom'];
			$_SESSION['user-data'][4] = $_POST['date'];
			$_SESSION['user-data'][5] = $_POST['adress'];
			$_SESSION['user-data'][6] = $_POST['email'];
			$_SESSION['user-data'][7] = $_POST['phone'];

			$_SESSION['user-data'][5] = str_replace(' ', "+", $_SESSION['user-data'][5]);
		    if (connexion()) {
				$id_connexion = $_SESSION['id_connexion'];
				$query = "UPDATE users SET username = '". $_SESSION['user-data'][0] . "', " . "first_name = '" . $_SESSION['user-data'][2] . "', " . "name = '" . $_SESSION['user-data'][3] . "', " . "birth = '" . $_SESSION['user-data'][4] . "', " .  "adress = '" . $_SESSION['user-data'][5] . "', " .  "email = '" . $_SESSION['user-data'][6] . "', " .  "phone = '" . $_SESSION['user-data'][7] . "' WHERE username = '" . $_SESSION['user'] . "'" ;
				if (($result = mysqli_query($id_connexion, $query))) {
				
				}
				deconnexion();
				unset($_SESSION['id_connexion']);
			}

			$_SESSION['user-data'][5] = str_replace('+', " ", $_SESSION['user-data'][5]);
			$_SESSION['user'] = $_POST['user'];

			if (!isset($afficher_message_avertissement)) {
				$modification_succes = TRUE;
			}
			else {$allow_modification = TRUE;}
		}
		//SI LE USERNAME VOULU EST INDISPONIBLE
		else {
			$erreur_utilisateur = TRUE;
			$allow_modification = TRUE;
			echo '<style> #user {background-color: #ff6d6d ; }</style>';
		}
	}
	//CODE QUI PERMET D'ACTIVER LE MODE CHANEGMENT DE MOT DE PASSE
	elseif (isset($_POST['changerMDP'])){
		$change_password = TRUE;
	}
	//CODE QUI PERMET LE CHANEGMENT DE MOT DE PASSE
	elseif(isset($_POST['valider-password'])){
		unset($password_failure);
		unset($password_succes);
		if (connexion()) {
			$id_connexion = $_SESSION['id_connexion'];
			$query = "SELECT * FROM users WHERE username = '". $_SESSION['user'] . "'";
			if (($result = mysqli_query($id_connexion, $query))) {
				$row = mysqli_fetch_row($result);
				if(password_verify($_POST['old_password'], $row[1])) {
					$password_failure = FALSE;
					if($_POST['new_password'] === $_POST['confirm_password']){
						$newPW = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
						$query = "UPDATE users SET password = '". $newPW . "' WHERE username = '" . $_SESSION['user'] . "'";
						if (($result2 = mysqli_query($id_connexion, $query))) {
							$password_succes = TRUE;
						}
					}
					else {$change_password = TRUE;}
				}
			}
			mysqli_free_result( $result );
			deconnexion();
			unset($_SESSION['id_connexion']);
		}
	}
	//CODE QUI PERMET DE SUPPRIMER LE COMPTE
	elseif(isset($_POST['supprimerCompte'])) {
		$delete_account = TRUE;
	}
	//CODE QUI CONFIRME LA SUPPRESSION
	elseif (isset($_POST['confirm-delete'])) {
		if (connexion()) {
			$id_connexion = $_SESSION['id_connexion'];
			$query = "DELETE FROM users WHERE username = '". $_SESSION['user'] . "'";
			if (($result = mysqli_query($id_connexion, $query))) {
			}
			deconnexion();
			unset($_SESSION['id_connexion']);
		}
		require "deconnexion.php";
		exit();
	}
	// CODE QUI PERMET DE REVENIR EN ARRIERE
	elseif (isset($_POST['back'])) {
	}
	//STYLE PAR DEFAUT DE LA PAGE
	else {
		echo '<style> #user, #prenom, #nom, #date, #email, #adress, #phone, #user {color: #999999;} </style>';
	}
?>