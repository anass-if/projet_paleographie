<?php


	include_once('../_includes/html0.php');
// ---------------------------------------------------
// ADMIN NEWS : LISTING
// ---------------------------------------------------
// requete : toutes les News
$validation_query 			= "SELECT * FROM validation ORDER BY date DESC;";
	$validation_result 			= mysqli_query($connexion_db,$validation_query);
	$validation_nombre 			= mysqli_num_rows($validation_result);
// -------------------------
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
<style>	

</style>
<!-- META -->
	<meta charset="utf-8" />
	<meta name="robots" content="noindex, nofollow" />
	<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
	<script src="js/popup.js"></script>
<!-- CSS -->
	<link rel="stylesheet" media="screen" type="text/css" href="../css/adm_theme_style.css" />
	<link rel="stylesheet" media="screen" type="text/css" href="../../modules/mod_news/css/news_style.css" />

<title>Gestion Inscription</title>
</head>
<body>
<div id="containerCentrer">
<h1>Gestion Inscription</h1>
<form id="boxBoutonTopRight" name="deconnexion" method="post" action="../_includes/_deconnexion.php">
	<fieldset>
		<button class="btDeconnexion" name="btDeconnexion" type="submit" title="Déconnexion de l'Administration">
		<span>Déconnexion</span></button>
	</fieldset>
	</form>
<div id="containerTop">
<div id="boxBoutonTopLeft">
		<a class="aLienRetour" href="gestion.php"><span>Retour</span></a>
	</div> 

	<h2>Liste des Inscriptions </h2>
	
</div>

<div id="containerListing">

	<h4>Total: <span class=notification><?php echo $validation_nombre; ?>.</span> </h4>
	<table>
	<thead>
	<tr>
	<th width="2%">N°</th>
		<th width="7%">Date</th>
		<th width="20%">Nom</th>
		<th width="20%">Prénom</th>
		<th width="30%">Email</th>
		<th width="10%">Valider</th>
		<th width="10%">Annuler</th>
	</tr>
	</thead>
	<tbody>
<?php
// -------------------------
if($validation_nombre>0) {
	// boucle pour lister
	$num=1;
	while ($validation_row = mysqli_fetch_array($validation_result))
	{
		// -------------------------
		$Id 			= intval($validation_row['id']);
		$date		=($validation_row['date']);
		$nom		=($validation_row['nom']);
		$prenom		=($validation_row['prenom']);
		$email		=($validation_row['email']);
		
?>
	<tr>
		
		<td><?php echo $num++; ?></td>
		<!-- date -->
		<td><?php echo date('d/m/Y', $date); ?></td>

		<td style="text-align:left;"><h4><?php echo $nom; ?></h4></td>
		
		<td style="text-align:left;"><h4><?php echo $prenom; ?></h4></td>
		<td style="text-align:left;"><h4><?php echo $email; ?></h4></td>

		<td><!-- Modifier -->
			<form method="post" name="formModifier" action="./news_formuler.php">
			<fieldset>
				<input type="hidden" name="traiter" value="Modifier" />
				
				<button name="btModifier" type="submit" title="Modifier l'Exercice" >
				<img src="<?php echo REP_ADM_ICONES; ?>valider.png" alt="Modifier l'Exercice" /></button>
			</fieldset>
			</form>
		</td>
		<td><!-- Supprimer -->
			<form method="post" name="formSupprimer" action="./news_formuler.php">
			<fieldset>
				<input type="hidden" name="traiter" value="Supprimer" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette entrée'));"/>
				
				<button name="btSupprimer" type="submit" title="Supprimer l'Exercice" class="aLienAnnuler">
				<img src="../icones/Annuler.png" alt="Supprimer l'Exercice" /></button>
			</fieldset>
			</form>
		</td>
	</tr>
<?php
	} // Fin foreach
} else { // pas de demandes
?>
	<tr><td colspan="8">Pas d'inscription.</td></tr>
<?php
}
?>
	</tbody>
	</table>
</div>
<div id="containerCopyright">
		<!-- Copyright -->
		<i>Panel d'Administration -Paléographie : </i>
	</div>

</div>
</body>
</html>