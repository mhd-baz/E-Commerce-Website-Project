        function isDate(idDate) {
            document.getElementById(idDate).setCustomValidity("");
            var ladate = new Date();
            
            var d = document.getElementById(idDate).value;

            if (d == "") // si la variable est vide on retourne faux
                return false;

            e = new RegExp("^([0-9]{4})\-[0-9]{1,2}\-[0-9]{1,2}$");

            if (!e.test(d)) // On teste l'expression régulière pour valider la forme de la date
            {   document.getElementById(idDate).setCustomValidity("Le format de la date doit être du type : jj-mm-aaaa")
                return false;} // Si pas bon, retourne faux

            // On sépare la date en 3 variables pour vérification, parseInt() converti du texte en entier
            a = parseInt(d.split("-")[0], 10); // année
            m = parseInt(d.split("-")[1], 10); // mois
            j = parseInt(d.split("-")[2], 10); // jour
            if (a > ladate.getFullYear()) {document.getElementById(idDate).setCustomValidity("La date doit être inférieur à celle du jour"); return false;}
            if ((a == ladate.getFullYear()) && (m > (ladate.getMonth()+1))) {document.getElementById(idDate).setCustomValidity("La date doit être inférieur à celle du jour"); return false;}
            if ((a == ladate.getFullYear()) && (m == (ladate.getMonth()+1)) && (j > ladate.getDate())) {
                document.getElementById(idDate).setCustomValidity("La date doit être inférieur à celle du jour");
                return false;}
            
            
            // Définition du dernier jour de février
            // Année bissextile si annnée divisible par 4 et que ce n'est pas un siècle, ou bien si divisible par 400
            if (a%4 == 0 && a%100 !=0 || a%400 == 0) fev = 29;
            else fev = 28;

            // Nombre de jours pour chaque mois
            nbJours = new Array(31,fev,31,30,31,30,31,31,30,31,30,31);

            // Enfin, retourne vrai si le jour est bien entre 1 et le bon nombre de jours, idem pour les mois, sinon retourn faux
            return ( m >= 1 && m <=12 && j >= 1 && j <= nbJours[m-1] );
        }

        function isName(isName) {
            document.getElementById(isName).setCustomValidity("");
            var name = document.getElementById(isName).value;
            e = new RegExp("^[A-Za-zÀ-ÿ]");
            if (e.test(name)) {
                e = RegExp("^[A-Za-zÀ-ÿ][A-Za-zÀ-ÿ'-]*$");
                if (!e.test(name)) {
                    document.getElementById(isName).setCustomValidity("Le champ ne peut pas contenir d'espaces ou de caratères sépciaux (sauf ' et -).");
                }
			}
            else{
                document.getElementById(isName).setCustomValidity("Le champ doit commencer par une lettre.");
			}
        }

        function isEmail(isEmail) {
            document.getElementById(isEmail).setCustomValidity("");
            var email = document.getElementById(isEmail).value;
            e = new RegExp("[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$");
            if (!e.test(email)) {
                document.getElementById(isEmail).setCustomValidity("L'email doit être au format [chaine_de_caractères]@[domaine].[extension_de_2_à_4_lettres]");
                return false;
			}
		}

        function isNumber(isPhone) {
            document.getElementById(isPhone).setCustomValidity("");
            var phone = document.getElementById(isPhone).value;
	        // Definition du motif a matcher
	        var regex = new RegExp(/^(01|02|03|04|05|06|07|08|09)[0-9]{8}$/gi);
	
	        // Definition de la variable booleene match
	        var match = false;
	
	        // Test sur le motif
	        if(!regex.test(phone))
	        {
		        document.getElementById(isPhone).setCustomValidity("Le numéro de télphone doit être composé de 10 chiffres avec pour premier chiffre 0.");
	        }
        }

        function isUser(isUser) {
            document.getElementById(isUser).setCustomValidity("");
            var user = document.getElementById(isUser).value;
            e = new RegExp("#[^\s]*#");
            if (!e.test(user)) {
                document.getElementById(isUser).setCustomValidity("Le nom d'utilisateur ne doit contenir aucun espace.");
			}
		}

        function isSamePassword(passwordFirst, passwordVerif) {
            document.getElementById(passwordVerif).setCustomValidity("");
            var value_passwordFirst = document.getElementById(passwordFirst).value;
            var value_passwordVerif = document.getElementById(passwordVerif).value;
            if (value_passwordFirst != value_passwordVerif) {
                document.getElementById(passwordVerif).setCustomValidity("Le nouveau mot de passe et sa confirmation doivent être identiques");
			}
		}
