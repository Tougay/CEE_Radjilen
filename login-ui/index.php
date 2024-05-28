                    <!DOCTYPE html>
<html lang="en">
<head>
	<title>Connexion - Système d'Examen en ligne</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="login-ui/image/png" href="images/icons/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="login-ui/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="login-ui/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="login-ui/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="login-ui/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="login-ui/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="login-ui/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="login-ui/vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="login-ui/css/util.css">
	<link rel="stylesheet" type="text/css" href="login-ui/css/main.css">
	<style>
		/* Ajoutez vos styles personnalisés ici */
/* Modifier la taille et la position du fond */
.container-login100 {
    background: url('assets/images/3968259.jpg') no-repeat center center fixed;
    background-size: cover;
    border-radius: 10px;
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
}

/* Modifier la couleur du titre */
.login100-form-title-1 {
    color: #fff; /* Couleur du texte en blanc */
}

/* Modifier la couleur du bouton de connexion */
.login100-form-btn {
    background-color: #4CAF50;
    
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    transition: background-color 0.3s ease;
}

.login100-form-btn:hover {
    background-color: #45a049;
}

		/* Ajoutez ici votre propre CSS personnalisé */
		body {
			font-family: Arial, sans-serif;
			background-color: #f0f0f0;
			margin: 0;
			padding: 0;
		}

		/* Personnalisez les styles de la zone de connexion */
		.container-login100 {
			background-color: #ffffff; /* Couleur de fond de la zone de connexion */
		}
       /* Ajoutez vos styles personnalisés ici */
/* Modifier la couleur du fond du conteneur de connexion */
.container-login100 {
    background-color: #ffffff;
    border-radius: 10px; /* Arrondir les coins du conteneur */
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1); /* Ajouter une ombre */
}

/* Modifier la taille du titre */
.login100-form-title-1 {
    font-size: 34px;
}

/* Modifier la couleur du bouton de connexion */
.login100-form-btn {
    background-color: #4CAF50;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    transition: background-color 0.3s ease;
}

.login100-form-btn:hover {
    background-color: #45a049; /* Changement de couleur au survol */
}

		/* Autres modifications de style selon vos préférences */
	</style>
</head>
<body>
	
	<div class="limiter">
		    <div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title">
					<span class="login100-form-title-1">
						Se Connecter
					</span>
				</div>

				<form method="post" id="examineeLoginFrm" class="login100-form validate-form">
					<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
						<span class="label-input100">Email</span>
						<input class="input100" type="text" name="username" placeholder="Enter email">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
						<span class="label-input100">Password</span>
						<input class="input100" type="password" name="pass" placeholder="Enter password">
						<span class="focus-input100"></span>
					</div>


					<div class="container-login100-form-btn" align="right">
						<button type="submit" class="login100-form-btn">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<script src="login-ui/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="login-ui/vendor/animsition/js/animsition.min.js"></script>
	<script src="login-ui/vendor/bootstrap/js/popper.js"></script>
	<script src="login-ui/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="login-ui/vendor/select2/select2.min.js"></script>
	<script src="login-ui/vendor/daterangepicker/moment.min.js"></script>
	<script src="login-ui/vendor/daterangepicker/daterangepicker.js"></script>
	<script src="login-ui/vendor/countdowntime/countdowntime.js"></script>
	<script src="login-ui/js/main.js"></script>

	<!-- Votre code JavaScript personnalisé peut être ajouté ici -->
<script>
// Ajoutez votre code JavaScript personnalisé ici
// Exemple: valider le formulaire avant de soumettre

document.getElementById("examineeLoginFrm").addEventListener("submit", function(event) {
    var email = document.getElementsByName("username")[0].value;
    var password = document.getElementsByName("pass")[0].value;

    if(email === "" || password === "") {
        event.preventDefault(); // Empêcher la soumission du formulaire
        alert("Veuillez remplir tous les champs.");
    }
});
	
	
</script>
</body>
</html>
