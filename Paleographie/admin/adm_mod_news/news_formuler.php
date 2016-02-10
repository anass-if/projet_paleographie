<?php

	include_once('../_includes/html0.php');
// ---------------------------------------------------
// ADMIN : FORMULAIRE "Ajouter"/"Modifier"/"Supprimer"
// ---------------------------------------------------
// -----------------
	$traiter 			= '';
if (isset($_POST['traiter']) && in_array($_POST['traiter'],array('Ajouter','Modifier','Supprimer'))) {
	$traiter 			= $_POST['traiter'];
} else {
	// sinon retour a la liste
	header('location: ./news_liste.php');
	exit;
}
// -------------------------
// Ajouter
if ($traiter=='Ajouter')
{
	$newsId 			= 0;
}
// -------------------------
// Modifier / Supprimer
elseif (in_array($traiter, array('Modifier','Supprimer')))
{
	$newsId 			= intval($_POST['newsId']);
}
// -------------------------
// On récupère les infos dans la BD (ou Initialisation si Ajouter)
	include('exercices_data_fromBD.php');
?>
<?php	include_once('../_includes/html1.php'); ?>
<title>Plaéographie | <?php echo $traiter; ?> un Exercice</title>
</head>
<body>
<div id="containerCentrer">
<h1>Administration des Exercices</h1>

<div id="containerTop">
	<h2><?php echo $traiter; ?> un Exercice</h2>
	<!-- Retour -->
	<div id="boxBoutonTopLeft">
		<a class="aLienRetour" href="./news_liste.php"><span>Retour à la Liste</span></a>
	</div> 
</div> 
<?php
// -------------------------
// initialisation
	$validNews 				= 0;
	$MsgValidOK 			= '';
	$MsgErreurChamps 		= '';
	$msgErreurPhoto 		= '';
	$msgErreurFile 			= '';
// -------------------------
// TRAITEMENT SI FORMULAIRE envoyé
if(isset($_POST['bt'.$traiter.'News']) && isset($_POST['codevalid']) && $_POST['codevalid']==$_SESSION['codevalid'])
{
	include_once('_inclus/exercices_traiter.php');
}
// On crée un code de validation, pour éviter le rafraichissement du formulaire (F5)
// (Si "Ajouter" : éviter de copier plusieurs fois le même enregistrement)
$_SESSION['codevalid']		= rand (10000, 90000);
// -------------------------
// AFFICHAGE du RECAPITULATIF
if($validNews==1)
{
	include_once('_inclus/news_recap.php');
}
// -------------------------
// AFFICHAGE du FORMULAIRE
elseif($validNews!=1)
{
?>

<?php if (in_array($traiter, array('Ajouter', 'Modifier'))) { ?>
	<!-- SCRIPT de VALIDATION du formulaire -->
	<script type="text/javascript" src="./js/exercice_valid.js"></script>
<?php } ?>

<div class="containerContenu">

<?php	if ($MsgErreurChamps!='' || $msgErreurPhoto!='' || $msgErreurFile!='') { ?>
			<?php echo ($MsgErreurChamps!='')? 	'<div class="boxMsgErreur">'.$MsgErreurChamps.'</div>' : ''; ?>
			<?php echo ($msgErreurPhoto!='')? 	'<div class="boxMsgErreur">'.$msgErreurPhoto.'</div>' : ''; ?>
			<?php echo ($msgErreurFile!='')? 	'<div class="boxMsgErreur">'.$msgErreurFile.'</div>' : ''; ?>
<?php	} ?>

<!-- formulaire -->
<form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="newsValidFormulaire(); return false;">
<fieldset>
	<input type="hidden" name="codevalid" value="<?php echo $_SESSION['codevalid']; ?>" />
	<input type="hidden" name="traiter" value="<?php echo $traiter; ?>" />
	<input type="hidden" name="newsId" value="<?php echo $newsId; ?>" />
	<input type="hidden" name="newsDate" value="<?php echo $newsDate; ?>" />
	<input type="hidden" name="newsPhotoAvant" value="<?php echo $newsPhotoAvant; ?>" />
	<input type="hidden" name="newsFileAvant" value="<?php echo $newsFileAvant; ?>" />

<?php // -------------------------
if (in_array($traiter, array('Ajouter', 'Modifier')))
{
?>
	<div id="containerContenuGauche">
		<h4>Exercice</h4>

		<p><!-- Publier ? -->
			<label><acronym title="Afficher l'Exercice sur le site ?">Publier</acronym> l'Exercice ? </label>
<?php		$Publier_Array = array(
							1	=>	'Oui',
							0	=>	'Non'
							);
			$pubAbbr_Array = array(
							1 	=>	'Oui, Publié sur le site',
							0 	=>	'Non, mais l\'Exercice est conservé (archivé)'
							);
			foreach ($Publier_Array as $val => $nom){
				$checked = ($newsPublier==$val)? ' checked="checked"' : '';
?>			<input class="radioInput" id="idnewsPublier<?php echo $val; ?>" name="newsPublier" type="radio" value="<?php echo $val; ?>"<?php echo $checked; ?> />
			<label class="radioLabel" for="idnewsPublier<?php echo $val; ?>"><abbr title="<?php echo $pubAbbr_Array[$val]; ?>"><?php echo $nom; ?></abbr> </label>
<?php 		} ?>
		</p>
		
		<p><!-- Devoir ? -->
			<label><acronym title="choisir l'exercice comme devoir ?">Devoir ?</acronym> </label>
<?php		$devoir_Array = array(
							1	=>	'Oui',
							0	=>	'Non'
							);
			foreach ($devoir_Array as $val => $nom){
				$checked = ($newsPublier==$val)? ' checked="checked"' : '';
?>			<input class="radioInput" id="idDevoir<?php echo $val; ?>" name="devoir" type="radio" value="<?php echo $val; ?>"<?php echo $checked; ?> />
			<label class="radioLabel" for="idDevoir<?php echo $val; ?>"><?php echo $nom; ?></label>
<?php 		} ?>
		</p>

		<p><!-- Titre -->
			<label for="idnewsTitre">Titre <abbr title="obligatoire">*</abbr>: </label>
			<input type="text" id="idnewsTitre" name="newsTitre" size="80" value="<?php echo $newsTitre; ?>" />
		</p>
		<p>
			<label for="Chapitre">Chapitre <abbr title="obligatoire">*</abbr>: </label>
			<select name="Chapitre" id="idChapitre" >
			<?php	if ($chapitre!=''){ // remarque : fctaffichimage() nécessite EN LOCAL un chemin relatif ?>
			<option selected="selected"><?php echo $chapitre; ?></option><?php } ?>
			  <option>1-Exemples d'écritures livresques</option>
			  <option>2-Paléotypographie</option>
			  <option>4-Eléments de repérage dans les incunables</option>
			   <option>5-Ecritures cursives des XVIIIe et XIXe siècles</option>
			    <option>6-Eléments de repérage dans les incunables</option>
				 <option>7-Documents sur les auteurs</option>
				  <option>8-Documents sur la fabrication des livres</option>
				   <option>9-Documents sur la circulation des livres</option>
				   <option>10-Documents sur le contrôle des écrits</option>
				   <option>11-Ecrire dans les marges et sur les pages blanches</option>
				   <option>12-L'écrit est partout</option>
				   
				</select> </br>
				<label for="Langue">Langue <abbr title="obligatoire">*</abbr>: </label>
			<select name="Langue" id="Langue" >
			  <option>Latin</option>
			  <option>Français</option>
			  <option>Occitan</option>
				</select> </br>
				<label for="Siecle">Siècle <abbr title="obligatoire">*</abbr>: </label>
			<select name="Siecle" id="Siecle" >
			  <option>V</option>
			  <option>VI</option>
			  <option>VII</option>
				</select> </br>
				<label for="Ecriture">Ecriture <abbr title="obligatoire">*</abbr>: </label>
			<select name="Ecriture" id="Ecriture" >
			  <option>Onciale</option>
			  <option>Caroline</option>
			  <option>Ecriture monastique</option>
			  <option>Cursive gothique</option>
			  <option>Humanistique</option>
			  <option>Romain</option>
			  <option>Gothique</option>
			  <option>Italique</option>
			  <option>Bâtarde</option>
			  <option>Cursive</option>
				</select> 
		</p>
		<p><!-- Contenu -->
			<label for="idnewsContenu">Contexte <abbr title="obligatoire">*</abbr>:</label>
			<textarea id="idnewsContenu" name="newsContenu" rows="5" cols="70"><?php echo htmlentities($newsContenu); ?></textarea>
		</p>
		<p><!-- Transcription -->
			<label for="idTranscription">Transcription <abbr title="obligatoire">*</abbr>:</label>
			<textarea id="idTranscription" name="Transcription" rows="5" cols="70"><?php echo htmlentities($transcription); ?></textarea>
		</p>
	</div>

	<div id="containerContenuDroit">
		<h4>Fac-similé</h4>

<?php	if ($newsPhotoAvant!=''){ // remarque : fctaffichimage() nécessite EN LOCAL un chemin relatif ?>
		<p><!-- Photo -->
			<img <?php echo fctaffichimage('../../upload/images/news_photos/'.$newsPhotoAvant, 150, 150); ?> alt="<?php echo $newsPhotoAvant; ?>" title="<?php echo $newsPhotoAvant; ?>" />
			<span style="float:right">
			<label class="checkboxLabel" for="idnewsPhotoDelete">Supprimer ? </label>
			<input class="checkboxInput" id="idnewsPhotoDelete" type="checkbox" name="newsPhotoDelete" value="ON" />
			</span>
		</p>
<?php	} ?>

		<p><!-- upload Photo -->
			<label for="idnewsPhoto"><?php echo ($newsPhotoAvant=='')? 'Joindre une Image' : 'Changer Image'; ?> : (<?php echo 'jpg,jpeg,png,gif'; ?>) </label><br />
			<input type="file" id="idnewsPhoto" name="newsPhoto" size="25" onchange="testExtension('idnewsPhoto','<?php echo htmlspecialchars('jpg,jpeg,png,gif'); ?>');" />
		</p>
		<p id="boxnewsPhotoLargeur" style="display:none;">
			<!-- largeur Photo -->
			<label for="idnewsPhotoLargeur">Largeur (affichage) : </label>
			<select id="idnewsPhotoLargeur" name="newsPhotoLargeur" size="1">
<?php			// Photo Largeur
				$PhoW_array 	= array(
								100 		=> 'mini : 100px',
								200 		=> 'petit : 200px',
								300 		=> 'normal : 300px',
								450 		=> 'moyen : 450px',
								600 		=> 'maxi : 600px'
								);
				foreach ($PhoW_array as $PhoW_val => $PhoW_nom)
				{
					$PhoW_Selected = (isset($newsPhotoLargeur) && $newsPhotoLargeur==$PhoW_val)? ' selected="selected"' : '';
?>					<option value="<?php echo $PhoW_val; ?>"<?php echo $PhoW_Selected; ?>><?php echo $PhoW_nom; ?></option>
<?php 			} ?>
			</select>
			<label for="Type">Type Document <abbr title="obligatoire">*</abbr>: </label>
			<select name="thelist" id="Type" >
			  <option>Lettre</option>
			  <option>documents notariaux</option>
			  <option>documents judiciaires</option>
			    <option>marques de possession</option>
				 <option>textes littéraires</option>
				 <option>autres</option>
				</select> </br>
		</p>

		<h4>Fichier</h4>

<?php	if ($newsFileAvant!=''){ ?>
		<p><!-- Fichier -->
			<label>Fichier :</label>
			<a href="../../upload/files/news_files/<?php $newsFileAvant; ?>" title="<?php echo $newsFileAvant; ?>" onclick="javascript:window.open(this.href); return false;">
			<img src="<?php echo REP_ADM_ICONES; ?>PDF.png" alt="<?php echo $newsFileAvant; ?>" /></a>
			<span style="float:right">
			<label class="checkboxLabel" for="idnewsFileDelete">Supprimer ? </label>
			<input class="checkboxInput" id="idnewsFileDelete" type="checkbox" name="newsFileDelete" value="ON" />
			</span>
		</p>
<?php	} ?>

		<p><!-- upload fichier -->
			<label for="idnewsFile"><?php echo ($newsFileAvant=='')? 'Joindre un Fichier' : 'Changer de Fichier'; ?> : (<?php echo 'pdf'; ?>)</label><br />
			<input type="file" id="idnewsFile" name="newsFile" size="25" onchange="testExtension('idnewsFile','<?php echo htmlspecialchars('pdf'); ?>');" />
		</p>

		<h4>Validation</h4>

		<div id="boxValidation">
			<div class="aLienAnnuler"><a href="./news_liste.php"><span>Annuler</span></a></div> 
			<button class="btValider btValider<?php echo $traiter; ?>" name="bt<?php echo $traiter; ?>News" type="submit">
			<span>Valider </span></button>
		</div> 

		<div id="boxLoading"></div>

	</div>

<?php
} // -------------------------
elseif ($traiter=='Supprimer')
{
?>
	<div id="containerContenuGauche">
		<h4>Exercice</h4>

		<p><!-- Publier ? (oui-non) -->
			<label><acronym title="Afficher l'Exercice sur le site ?">Publier</acronym> : </label>
			<?php if($newsPublier==1) { ?>Oui<?php } elseif($newsPublier==0) { ?>Non<?php } ?>
		</p>

		<p><!-- Titre -->
			<label>Titre : </label>
			<b><?php echo $newsTitre; ?></b>
		</p>
	</div>
	<div id="containerContenuDroit">
	<h4>Fac-similé</h4>
<?php	if ($newsPhotoAvant!=''){ // remarque : EN LOCAL, fctaffichimage() nécessite un chemin relatif ?>
		<p><!-- Photo -->
			<label style="min-width:30px;">
			<img <?php echo fctaffichimage('../../'.NEWS_REP_PHOTOS.$newsPhotoAvant, 24, 24); ?> alt="<?php echo $newsPhotoAvant; ?>" title="<?php echo $newsPhotoAvant; ?>" />
			</label>
			(l'image sera aussi supprimée)
		</p>
<?php	} ?>

<?php	if ($newsFileAvant!=''){ ?>
		<p><!-- Fichier -->
			<a href="<?php echo '../../'.NEWS_REP_FILES.$newsFileAvant; ?>" onclick="javascript:window.open(this.href); return false;">
			<label style="min-width:30px;"><img src="<?php echo REP_ADM_ICONES; ?>PDF.png" alt="<?php echo $newsFileAvant; ?>" /></a></label>
			(le fichier sera aussi supprimé)
		</p>
<?php	} ?>

		<h4>Validation</h4>

		<div id="boxValidation">
			<div class="aLienAnnuler"><a href="./news_liste.php"><span>Annuler</span></a></div> 
			<button class="btValider btValider<?php echo $traiter; ?>" name="bt<?php echo $traiter; ?>News" type="submit">
			<span>Valider </span></button>
		</div> 

		<div id="boxLoading"></div>

	</div>

<?php
} 
?>
</fieldset>
</form>
</div>
<?php
} // fin AFFICHAGE du FORMULAIRE
?>
<div id="containerCopyright">
		<!-- Copyright -->
		<i>Panel d'Administration - WebDesign : </i>
	</div>

</div>
</body>
</html>