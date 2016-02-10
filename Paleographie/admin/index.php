<?php	session_start();

// CONFIGURATION GENERALE + de la NEWS
	include_once('_includes/_protect_index.php');
// ------------------------------------------------------
// sinon affichage du formulaire d'identification
?>
<!DOCTYPE html>
<html dir="ltr">
<head>
<!-- META -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	
<!-- CSS -->
	<link rel="stylesheet" media="screen" type="text/css" href="./css/adm_theme_style.css" />
	<title>Paléographie | Administration </title>
</head>

<body>
<div id="containerCentrer">

	<h1>Administration Paléographie</h1>

	<!-- identification - connexion -->
	<div id="boxIndexIdentificationForm">
		<form method="post" action="./index.php">
		<fieldset>
			<h3><img src="./icones/verrouiller.png" alt="" /> Identifiez-vous :</h3>

<?php	if(isset($msgerreur) && $msgerreur!='') { ?>
			<p class="boxMsgErreur"><?php echo $msgerreur; ?></p>
<?php	} ?>
			<p>
				<label for="idlogin" style="text-align:right;">Identifiant : </label>
				<input id="idlogin" name="login" size="20" />
			</p>

			<p>
				<label for="idpass" style="text-align:right;">Mot de passe : </label>
				<input id="idpass" name="pass" type="password" size="20" />
			</p>
			<p style="text-align:center;">
				<button class="btConnexion" name="btConnexion" type="submit" title="Connexion">
				<span>Connexion</span></button>
			</p>

		</fieldset>
		</form>

			<p style="text-align:center;">
				<!-- retour au site -->
				<a class="aRetourSite" href="../index.php"><span>Retour au site</span></a>
			</p>
	</div>

</div>
</body>
</html>