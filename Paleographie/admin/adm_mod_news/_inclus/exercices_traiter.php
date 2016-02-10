<?php

$traiter = '';
if (isset($_POST['traiter']) && ($_POST['traiter']!='Ajouter' || $_POST['traiter']!='Modifier' || $_POST['traiter']!='Supprimer')){
	$traiter = $_POST['traiter'];
} else {
	// sinon retour a la liste
	header('location: ./news_liste.php');
	exit;
}
// --------------------
// initialisation
	$MsgValidAjouter 		= 'L\'Exercice a été ajouté.';
	$MsgValidModifier 		= 'L\'Exercice a été modifié.';
	$MsgValidSupprimer 		= 'L\'Exercice a été supprimé.';

// -------------------------
if (in_array($traiter,array('Ajouter','Modifier')))
{
	// -----------------------------------------
	// 1- RECUPERATION DES DONNEES DU FORMULAIRE
	// -----------------------------------------
	$newsId 				= (isset($_POST['newsId']))?			intval($_POST['newsId']) : 0;
	$newsTitre 				= (isset($_POST['newsTitre']))?			($_POST['newsTitre']) : '';
	$chapitre 				= (isset($_POST['Chapitre']))?			($_POST['Chapitre']) : '';
	$newsContenu 			= (isset($_POST['newsContenu']))?		($_POST['newsContenu']) : ''; 	// textarea
	$newsPublier 			= (isset($_POST['newsPublier']))?		intval($_POST['newsPublier']) : 1; // Oui
	$newsDate 				= (isset($_POST['newsDate']))?			intval($_POST['newsDate']) : time(); // date du jour par défaut
	$transcription			= (isset($_POST['Transcription']))?		($_POST['Transcription']) : ''; 	// textarea
	
	// -----------------------------------------
	// 2- GESTION des ERREURS
	// -----------------------------------------
	// Expression régulière pour vérifier qu'aucun en-tête n'est inséré dans les champs
	$regex_head = '/[\n\r]/';
	// pas de header dans les champs text */
	if (preg_match($regex_head, $newsTitre)) {
		$MsgErreurChamps 	.= 'Entêtes interdites dans les champs du formulaire !<br />';
		$validNews 	= 2;
	}
	// ---------------------
	// champs obligatoires
	$champ_obligatoire = array();
	if ($newsTitre=='') {			$validNews = 2;		$champ_obligatoire[] = 'Titre'; }
	if ($newsContenu=='') {			$validNews = 2;		$champ_obligatoire[] = 'Contenu'; }
	if ($transcription=='') {		$validNews = 2;		$champ_obligatoire[] = 'transcription'; }
	if($validNews==2 && count($champ_obligatoire)>0) {
		$MsgErreurChamps 	.= 'Remplissez tous les champs obligatoires :<br /><b>'.implode('</b>, <b>',$champ_obligatoire).'</b><br />';
	}
	// ---------------------
	if ($validNews!=2) {
		$validNews 	= 1;
		// -----------------
	}

	// -----------------------------------------
	// 3- ENREGISTREMENT
	// -----------------------------------------
	// Ajouter
	if ($validNews==1 && $traiter=='Ajouter')
	{
		// INSERT : nouvelle entree dans la table
		// on met la date du jour (timestamp) : time()
		$insert_query 		= "INSERT INTO news_tab_articles(".
							" news_titre, ".
							" chapitre, ".
							" news_contenu, ".
							" transcription, ".
							" news_publier, ".
							" news_date ".
							") VALUES (".
							" '".mysqli_real_escape_string($connexion_db,$newsTitre)."', ".
							" '".mysqli_real_escape_string($connexion_db,$chapitre)."', ".
							" '".mysqli_real_escape_string($connexion_db,$newsContenu)."', ".
							" '".mysqli_real_escape_string($connexion_db,$transcription)."', ".
							" '".mysqli_real_escape_string($connexion_db,$newsPublier)."', ".
							" '".mysqli_real_escape_string($connexion_db,$newsDate)."'". // (pas de virgule)
							");";
//		mysql_query($insert_query) or die('Erreur SQL :<br />'.$insert_query.'<br />'.mysql_error()); // TEST LOCAL
		mysqli_query($connexion_db,$insert_query);
		// -----------------
		$MsgValidOK 		= $MsgValidAjouter;
		$traiter 			= 'Modifier';	// Ajouter -> Modifier
		// ----------------------
		// recuperation de news_id en selectionnant LA DERNIERE fiche cree
		$maxid_query 		= "SELECT MAX(news_id) AS idmax FROM news_tab_articles;";
//		$maxid_result 		= mysql_query($maxid_query) or die('Erreur SQL :<br />'.$maxid_query.'<br />'.mysql_error()); // TEST LOCAL
		$maxid_result 		= mysqli_query($connexion_db,$maxid_query);
		$maxid_row 			= mysqli_fetch_array($maxid_result);
		$newsId 			= $maxid_row['idmax'];
		// -----------------
	} // fin Ajouter

	// -----------------------------------------
	// Modifier
	elseif ($validNews==1 && $traiter=='Modifier')
	{
		// on ne change pas la date
		// UPDATE de la fiche :
		$update_query 		= "UPDATE news_tab_articles SET ".
							" news_titre 			= '".mysqli_real_escape_string($connexion_db,$newsTitre)."', ".
							" chapitre				='".mysqli_real_escape_string($connexion_db,$chapitre)."', ".
							" news_contenu 			= '".mysqli_real_escape_string($connexion_db,$newsContenu)."', ".
							" transcription			= '".mysqli_real_escape_string($connexion_db,$transcription)."', ".
							" news_publier 			= '".mysqli_real_escape_string($connexion_db,$newsPublier)."', ".
							" news_date 			= '".mysqli_real_escape_string($connexion_db,$newsDate)."' ". // (pas de virgule)
							" WHERE news_id 		= '".mysqli_real_escape_string($connexion_db,$newsId)."';";
//		mysql_query($update_query) or die('Erreur SQL :<br />'.$update_query.'<br />'.mysql_error()); // TEST LOCAL
		mysqli_query($connexion_db,$update_query);
		// -----------------
		$MsgValidOK 	= $MsgValidModifier;
	} // fin Modifier

	// -----------------------------------------
	// Ajouter ou Modifier
	// -----------------------------------------
	if ($validNews==1 && in_array($traiter, array('Ajouter', 'Modifier')))
	{
		// ----------------------
		// traitement Photo ?
		include(__DIR__ . '/news_traiter_photo.php');
		// ----------------------
		// traitement Fichier ?
		include(__DIR__ . '/news_traiter_file.php');
	} // fin Ajouter/Modifier
}
// -------------------------
// Traitement : Supprimer
// -------------------------
elseif ($traiter == 'Supprimer')
{
	$newsId 				= (isset($_POST['newsId']))?				intval($_POST['newsId']) : 0;
	$newsPhotoAvant 		= (isset($_POST['newsPhotoAvant']))? 		($_POST['newsPhotoAvant']) : '';
	$newsFileAvant 			= (isset($_POST['newsFileAvant']))? 		($_POST['newsFileAvant']) : '';
	// ----------------------
	// Suppression de la Fiche dans la BD
	$delete_query 			= "DELETE FROM news_tab_articles ".
							" WHERE news_id = '".mysqli_real_escape_string($connexion_db,$newsId)."';";
//	mysql_query($delete_query) or die('Erreur SQL :<br />'.$delete_query.'<br />'.mysql_error()); // TEST LOCAL
	mysqli_query($connexion_db,$delete_query);
	// -----------------
	$MsgValidOK 			= $MsgValidSupprimer;
	$validNews				= 1;
	// ----------------------
	// Suppression de la Photo du dossier
	if($newsPhotoAvant!='' && file_exists('../../upload/images/news_photos/'.$newsPhotoAvant)) {
		unlink('../../upload/images/news_photos/'.$newsPhotoAvant);
	}
	// ----------------------
	// Suppression du Fichier du dossier
	if($newsFileAvant!='' && file_exists('../../'.NEWS_REP_FILES.$newsFileAvant)) {
		unlink('../../'.NEWS_REP_FILES.$newsFileAvant);
	}
	// ----------------------
}
// -------------------------
unset($_POST);
