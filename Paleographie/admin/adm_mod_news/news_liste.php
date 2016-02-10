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

<title>Gestion Exercices</title>
</head>
<body>
<div id="containerCentrer">
<h1>Gestion Exercices</h1>
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
	
	<!-- Ajouter -->
	<form id="boxBoutonRight" method="post" name="formAjouter" action="./news_formuler.php">
	<fieldset>
		<input type="hidden" name="traiter" value="Ajouter" />
		<button class="btAjouter" name="btAjouter" type="submit" title="Ajouter un Nouveau Exercice">
		<span>Ajouter un Exercice</span></button>
	</fieldset>
	</form>
</div>

<div id="containerListing">

	
	<table>
	<caption><h2>Liste des Exercices </h2>
	<h4>Total: <span class=notification><?php echo $news_nombre; ?></span> </h4></caption>
	<thead>
	<tr>
	<th width="2%">ID</th>
		<th width="7%">Date</th>
		<th>Titre de l'Exercice</th>
		<th width="5%">Fac-sim.</th>
		<th width="5%">Pdf</th>
		<th width="4%">Publier</th>
		<th width="4%">Voir</th>
		<th width="4%">Modifier</th>
		<th width="4%">Supprimer</th>
	</tr>
	</thead>
	<tbody>
<?php
// -------------------------
if($news_nombre>0) {
	// boucle pour lister
	$num=1;
	while ($news_row = mysqli_fetch_array($news_result))
	{
		// -------------------------
		$newsId 			= intval($news_row['news_id']);
		// On recupere les infos dans la BD
		require('exercices_data_fromBD.php');
		// -------------------------
?>
	<tr>
		
		<td><?php echo $num++; ?></td>
		<!-- date -->
		<td><?php echo date('d/m/Y', $newsDate); ?></td>

		<td style="text-align:left;"><h4><?php echo $newsTitre; ?></h4></td>
		
		<td><!-- Photo -->
<?php	if($newsPhoto!='') { ?>
			<a href="../../upload/images/news_photos/<?php echo $newsPhoto; ?>" class="lightbox_trigger" >
			<img src="../../upload/images/news_photos/<?php echo $newsPhoto;  ?>" style="height:30px;" alt="<?php echo $newsPhoto; ?>" title="<?php echo $newsPhoto; ?>" /></a> 
<?php	} else { ?>
			<img src="<?php echo REP_ADM_ICONES; ?>ico_checkNon.png" alt="pas de photo" title="pas de photo" />
<?php	} ?>
		</td>

		<td><!-- Fiche PDF -->
<?php		if($newsFile != '') { ?>
			<a href="../../upload/files/news_files/<?php echo $newsFile; ?>" onclick="javascript:window.open(this.href); return false;">
			<img src="<?php echo REP_ADM_ICONES; ?>PDF.png" alt="<?php echo $newsFile; ?>" title="<?php echo $newsFile; ?>" /></a> 
<?php		} else { ?>
			<img src="<?php echo REP_ADM_ICONES; ?>PDFnon.png" alt="pas de fiche PDF" title="pas de fichier" />
<?php		} ?>
		</td>

		<td><!-- Publier Exercice : oui / non / toujours -->
			<?php	switch ($newsPublier) {
			case 0:	// non 		?><span class="icoCheckNon" title="Non"></span>
			<?php	break;
			case 1:	// oui		?><span class="icoCheckOui" title="Oui"></span>
			<?php	break;
			} ?>
		</td>

		<td><!-- Voir -->
			<form method="post" name="formvoirFiche" action="./news_fiche.php">
			<fieldset>
				<input type="hidden" name="newsId" value="<?php echo $newsId; ?>" />
				<button name="btModifier" type="submit" title="Voir l'Exercice">
				<img src="<?php echo REP_ADM_ICONES; ?>VoirFiche.png" alt="Voir l'Exercice" /></button>
			</fieldset>
			</form>
		</td>

		<td><!-- Modifier -->
			<form method="post" name="formModifier" action="./news_formuler.php">
			<fieldset>
				<input type="hidden" name="traiter" value="Modifier" />
				<input type="hidden" name="newsId" value="<?php echo $newsId; ?>" />
				<button name="btModifier" type="submit" title="Modifier l'Exercice">
				<img src="<?php echo REP_ADM_ICONES; ?>Modifier.png" alt="Modifier l'Exercice" /></button>
			</fieldset>
			</form>
		</td>
		<td><!-- Supprimer -->
			<form method="post" name="formSupprimer" action="./news_formuler.php">
			<fieldset>
				<input type="hidden" name="traiter" value="Supprimer" />
				<input type="hidden" name="newsId" value="<?php echo $newsId; ?>" />
				<button name="btSupprimer" type="submit" title="Supprimer l'Exercice">
				<img src="../icones/Supprimer.png" alt="Supprimer l'Exercice" /></button>
			</fieldset>
			</form>
		</td>
	</tr>
<?php
	} // Fin foreach
} else { // pas de news
?>
	<tr><td colspan="8">Pas d'exercice.</td></tr>
<?php
}
?>
	</tbody>
	</table>
</div>
<div id="containerCopyright">
		<!-- Copyright -->
		<i>Panel d'Administration </i>
	</div>

</div>
</body>
</html>