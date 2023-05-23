<?php
    session_start();
    // S'il y des données de postées
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        $dateDuContact = $_POST["dateDuContact"];
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST['email'];
        $genre = $_POST['genre'];
        $dateDeNaissance = $_POST['dateDeNaissance'];
        $fonction = $_POST['fonction'];
        $sujetMail = $_POST['sujetMail'];
        $contenu = $_POST['contenu'];
        
        function valide_pre_nom($donnee) {
            return ( (!empty($donnee)) && (preg_match("#[A-Za-zÀ-ÿ][A-Za-zÀ-ÿ'-]*#",$donnee)) );
		}

        function valide_email($mail) {
            return ( (!empty($mail)) && (preg_match("#[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$#",$mail)) ); 
		}

        function valide_genre($genre) {
            return ( ($genre == "homme") || ($genre == "femme") ); 
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

        function valide_texte($texte) {
              return !empty($texte);
		}

        $genre_f = '';
        $genre_h = '';

        $messages_derreur = '';

        echo '<style> #dateDuContact, #nom, #prenom, #email, #femme, #homme, #dateDeNaissance, #sujetMail, #contenuMail  {
                  background-color: white;
             </style>';

        $drapeau = FALSE;

        if (!valide_date($dateDuContact)) {
            $dateDuContact = "";
            $messages_derreur .= "Vérifier la validité de la date de contact, de plus elle doit être inférieure ou égale à celle du jour." . "<br>";
            $drapeau = TRUE;
            echo '<style> #dateDuContact {
                    background-color: red;
                  </style>';
		}

        if (!valide_pre_nom($nom)) {
            $nom = "";
            $messages_derreur .= "Le nom ne doit pas comporter de caractères spéciaux et/ou d'espaces." . "<br>";
            $drapeau = TRUE;
            echo '<style> #nom {
                    background-color: red;
                  </style>';
		}

        if (!valide_pre_nom($prenom)) {
            $prenom = "";
            $messages_derreur .= "Le prénom ne doit pas comporter de caractères spéciaux et/ou d'espaces." . "<br>";
            $drapeau = TRUE;
            echo '<style> #prenom {
                    background-color: red;
                  </style>';
		}

        if (!valide_email($email)) {
            $email = "";
            $messages_derreur .= "Le mail doit être du format <i> [chaine_de_caractères]@[domaine].[extension_de_2_à_4_lettres] </i>" . "<br>";
            $drapeau = TRUE;
            echo '<style> #email {
                    background-color: red;
                  </style>';
		}

        if (!valide_genre($genre)) {
            $genre = "";
            $messages_derreur .= "Vous devez sélectionner un genre." . "<br>";
            $drapeau = TRUE;
            echo '<style> #femme, #homme {
                    background-color: red;
                  </style>';
		}
        else {
            if ($genre == "homme") {$genre_h = "checked";} 
            else {$genre_f = "checked";}
		}

        if (!valide_date($dateDeNaissance)) {
            $dateDeNaissance = "";
            $messages_derreur .= "Vérifier la validité de la date de naissance, de plus elle doit être inférieure ou égale à celle du jour." . "<br>";
            $drapeau = TRUE;
            echo '<style> #dateDeNaissance {
                    background-color: red;
                  </style>';
		}

        if (!valide_texte($sujetMail)) {
            $sujetMail = "";
            $messages_derreur .= "Le sujet du message ne peut être vide." . "<br>";   
            $drapeau = TRUE;
            echo '<style> #sujetMail {
                    background-color: red;
                  </style>';
		}

        if (!valide_texte($contenu)) {
            $contenu = "";
            $messages_derreur .= "Le contenu du message ne peut être vide." . "<br>"; 
            $drapeau = TRUE;
            echo '<style> #contenuMail {
                    background-color: red;
                  </style>';
		}

        $choice = array('', '', '', '', '', '', '', '', '', '', '', '');
        $liste_des_fonctions = array('SansActivite', 'cadreFonctionPublique', 'candreEntreprise', 'etudiant', 'enseignant', 'artisan', 'technicien', 'ouvrier', 'agriculteur', 'commercant', 'retraite', 'nonRenseigne');
        for ($i=0; $i<12; $i++){
            if($fonction ==  $liste_des_fonctions[$i]) {
                $choice[$i] = 'selected';
		    }
		}

        if ($drapeau) {
            require 'contact.inc.php';  
		}
        else {
            $header = "From:\"Street'N Chic Contact\" <webmaster.projet0@gmail.com>\n";
            $header .= "Content-Type: text; charset=\"utf-8\"\n" ;
            $sujet_mail = "Formulaire de Contact";
            $message = "dateDuContact=" . $dateDuContact . "\r\n";
            $message .= ("nom=" . $nom . "\r\n");
            $message .= ("prenom=" . $prenom . "\r\n");
            $message .= ("email=" . $email . "\r\n");
            $message .= ("genre=" . $genre . "\r\n");
            $message .= ("dateDeNaissance=" . $dateDeNaissance . "\r\n");
            $message .= ("fonction=" . $fonction . "\r\n");
            $message .= ("sujet=" . $sujetMail . "\r\n");
            $message .= ("contenu=" . wordwrap($contenu, 70, "\r\n"));
            if (mail ("webmaster.projet0@gmail.com", $sujet_mail, $message, $header)) {
                $_SESSION['mail_sended'] = TRUE;
            }
            else {
                $_SESSION['mail_failed'] = TRUE;
			}
            header("Location: contact.php");
            exit();
		}
    }
  
?>