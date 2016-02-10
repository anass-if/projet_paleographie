<?php


	include_once('../_includes/html0.php');
// ---------------------------------------------------
// ADMIN NEWS : LISTING
// ---------------------------------------------------
// requete : toutes les News
	$news_query 			= "SELECT * FROM news_tab_articles ORDER BY news_date DESC;";
//	$news_result 			= mysql_query($news_query) or die('Erreur SQL :<br />'.$news_query.'<br />'.mysql_error()); // TEST LOCAL
	$news_result 			= mysqli_query($connexion_db,$news_query);
	$news_nombre 			= mysqli_num_rows($news_result);
// requete : validation	
	$validation_query 			= "SELECT * FROM validation ORDER BY date DESC;";
	$validation_result 			= mysqli_query($connexion_db,$validation_query);
	$validation_nombre 			= mysqli_num_rows($validation_result);
// -------------------------
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
<!-- META -->
	<meta charset="utf-8" />
	<meta name="robots" content="noindex, nofollow" />
	<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
	<script src="js/popup.js"></script>
<!-- CSS -->
	<link rel="stylesheet" media="screen" type="text/css" href="../css/adm_theme_style.css" />
	<link rel="stylesheet" media="screen" type="text/css" href="../../modules/mod_news/css/news_style.css" />

<title>Gestion Exercices</title>
</head>
<body>
<div id="containerCentrer">
<h1>Panneau d'administration</h1>
<form id="boxBoutonTopRight" name="deconnexion" method="post" action="../_includes/_deconnexion.php">
	<fieldset>
		<button class="btDeconnexion" name="btDeconnexion" type="submit" title="Déconnexion de l'Administration">
		<span>Déconnexion</span></button>
	</fieldset>
	</form>
<div id="containerTop">

<!-- Ajouter -->
<table id="tableau">
	<tr width="100px" >
	<td colspan=3><span class=bonjour>Bonjour, vous avez :</span></td>
	</tr>
	<tr>
	<td><a  href="validation.php" > <span class=notification><?php echo $validation_nombre ?>.</span><span class=msg>Demande<?php if($validation_nombre>1) { echo 's'; } ?> d'inscription</span></a></td>
	<td><a  href="devoir.php" > <span class=notification>12</span><span class=msg>Devoir<?php if($news_nombre>1) { echo 's'; } ?> rendus</span></a></td>
	</tr>
	</table>
	
</div>

<div id="containerListing">

	
	<table id="tableauB">
	<thead>
	<tr>
	<th colspan=3><span class=tbord>Tableau de bord</span></th>
	</tr>
	</thead>
	<tbody>
<tr>
	<td><a href="news_liste.php">
	<img src="../icones/exercice.jpg">
	<h2>Gestion Exercices</h2></a>
	</td>
	<td ><a href="">
	<img src="../icones/user-group-icon.png">
	<h2>Gestion Etudiants</h2></a>
	</td>
	<td ><a href="">
	<img src="../icones/commentaire.png">
	<h2>Gestion Commentaires</h2></a>
	</td>
	</tr>
	</tbody>
	</table>
</div>
<div id="containerCopyright">
		<!-- Copyright -->
		<i align=center>Gestion Paléographie:</i>2015/2016
	</div>

</div>
</body>
</html>