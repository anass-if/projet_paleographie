<?php
// © Jérome Réaux : http://j-reaux.developpez.com - http://www.jerome-reaux-creations.fr
// ---------------------------------------------------
// ADMIN NEWS : TRAITEMENT des photos
// ---------------------------------------------------
// RECUPERATION DES DONNEES DU FORMULAIRE
// PHOTO

$newsPhotoAvant 		= (isset($_POST['newsPhotoAvant']))? 		($_POST['newsPhotoAvant']) : '';
	$newsPhotoDelete 		= (isset($_POST['newsPhotoDelete']))? 		($_POST['newsPhotoDelete']) : '';
	$newsPhotoLargeur 		= (isset($_POST['newsPhotoLargeur']))? 		($_POST['newsPhotoLargeur']) : '';

// -----------------
// Gestion des PHOTOS supprimees
if ($newsPhotoAvant!='' && $newsPhotoDelete=='ON')
{
	// Suppression de l'ancienne PHOTO
	if(file_exists('../../'.NEWS_REP_PHOTOS.$newsPhotoAvant)) {
		unlink('../../'.NEWS_REP_PHOTOS.$newsPhotoAvant);
	}
	// -----------------
	// Suppression dans la base de donnees par UPDATE
	$update_query 			= "UPDATE news_tab_articles ".
							" SET news_photo 	= '' ".
							" WHERE news_id 	= '".mysqli_real_escape_string($connexion_db,$newsId)."';";
	$update_result 			= mysqli_query($connexion_db,$update_query);
	// -----------------
}

// ----------------------------------
// VERIFICATION / TRAITEMENT de la PHOTO si uploadee
// ----------------------------------
$msgErreurPhoto 			= ''; 	// message d erreur
$traiterPhotoOK 			= true; // (par defaut)

if(isset($_FILES['newsPhoto']) && $_FILES['newsPhoto']['size']>0)
{
	// -------------------------------------
	// extension du fichier uploadé (en minuscule)
	$file_Extension 		= strtolower(pathinfo($_FILES['newsPhoto']['name'],PATHINFO_EXTENSION));

	// Type MIME réel du fichier (IMPORTANT : évite les fichiers NON valides, dont l'extension a été renommée)
//	$finfo 					= new finfo(FILEINFO_MIME_TYPE, NULL); // Retourne le type mime
//	$file_MimeType 			= $finfo->file($_FILES['newsPhoto']['tmp_name']);

	// (alternative, si la CLASS finfo n'est pas supportée)
	$finfo 					= finfo_open(FILEINFO_MIME_TYPE); // Retourne le type mime à la extension mimetype
	$file_MimeType 			= finfo_file($finfo, $_FILES['newsPhoto']['tmp_name']);
	finfo_close($finfo);

	// -------------------------------------
	// GESTION DES ERREURS
	// -------------------------------------
	// on vérifie les RESTRICTIONS sur les fichiers
	if (UPLOAD_ERR_OK<>0 && UPLOAD_ERR_FORM_SIZE==2) {
		$msgErreurPhoto 	.= 'Taille de fichier trop important ('.NEWS_SIZEMAX_PHOTO.' octets)<br />';
		$traiterPhotoOK 	= false;
	}
	// -----------------
	// on vérifie la TAILLE MAXI
	elseif ($_FILES['newsPhoto']['size'] > NEWS_SIZEMAX_PHOTO) {
		$msgErreurPhoto 	.= 'Taille de fichier supérieure à la taille maxi autorisée ('.NEWS_SIZEMAX_PHOTO.' octets)<br />';
		$traiterPhotoOK 	= false;
	}
	// -----------------
	// on vérifie l'EXTENSION
	elseif(!in_array($file_Extension, explode(',', constant('NEWS_EXTENSION_PHOTO')))) {
		$msgErreurPhoto 	.= 'L\'extension ne correspond pas (Extensions acceptées  : <b>'.constant('NEWS_EXTENSION_PHOTO').'</b>)<br />';
		if(in_array($file_MimeType, explode(',', constant('NEWS_MIMETYPE_PHOTO')))) {
		  $msgErreurPhoto 	.= '<b>Attention</b> : Ce fichier est peut-être corrompu !<br />';
		  $msgErreurPhoto 	.= 'L\'extension ne correspond pas au type MIME !<br />';
		}
		$traiterPhotoOK 	= false;
	}
	// -----------------
	// on vérifie le TYPE MIME
	elseif(!in_array($file_MimeType, explode(',', constant('NEWS_MIMETYPE_PHOTO')))) {
		$msgErreurPhoto 	.= 'Le type MIME ne correspond pas (Extensions acceptées  : <b>'.constant('NEWS_EXTENSION_PHOTO').'</b>)<br />';
		if(in_array($file_Extension, explode(',', constant('NEWS_EXTENSION_PHOTO')))) {
		  $msgErreurPhoto 	.= '<b>Attention</b> : Ce fichier est peut-être corrompu !<br />';
		  $msgErreurPhoto 	.= 'L\'extension ne correspond pas au type MIME !<br />';
		}
		$traiterPhotoOK 	= false;
	}
	// -----------------
	if ($traiterPhotoOK===false) {
		$msgErreurPhoto 	= '<b>Erreur (Photo)</b> :<br />'.$msgErreurPhoto.'Impossible d\'enregistrer le fichier.';
	}
	// -------------------------------------
	// si pas d'erreur : TRAITEMENT
	// -------------------------------------
	if ($traiterPhotoOK===true)
	{
		// --------------------
		// enregistement de la PHOTO sous forme id_nom-image(.jpg, ...)
		// NB : id etant unique (auto-increment), cela rend le nom de la photo unique
		$file_Upload 		= $newsId.'_'.$_FILES['newsPhoto']['name'];
		$file_Upload 		= formatage_nom_fichier($file_Upload); // remplacement des caracteres speciaux + tout en minuscules
		$file_Upload 		= str_replace('.jpeg','.jpg',$file_Upload); // on remplace aussi .jpeg par .jpg
		// --------------------
		// enregistrement de la photo dans le dossier
		$temp = $_FILES['newsPhoto']['tmp_name'];
		move_uploaded_file($temp, '../../'.NEWS_REP_PHOTOS.$file_Upload);
		// --------------------
		// REDIMENSIONNEMENT et SAUVEGARDE de la PHOTO (si necessaire)
		// ecraser (remplacer) la photo (meme rep, meme nom)
		$redimPHOTOOK 		= fctredimimage($newsPhotoLargeur,0,'','','../../'.NEWS_REP_PHOTOS,$file_Upload);
		// --------------------
		// SUPPRESSION des ANCIENNES PHOTOS (si necessaire) dans le dossier
		if ($newsPhotoAvant!='' && $newsPhotoAvant!=$file_Upload)
		{
			if(file_exists('../../'.NEWS_REP_PHOTOS.$newsPhotoAvant)) {
				unlink('../../'.NEWS_REP_PHOTOS.$newsPhotoAvant);
			}
		}
		// -----------------
		// enregistrement du NOM dans la base de donnees par UPDATE
		$update_query 		= "UPDATE news_tab_articles SET ".
							" news_photo 			= '".mysqli_real_escape_string($connexion_db,$file_Upload)."', ".
							" news_photo_largeur	= '".mysqli_real_escape_string($connexion_db,$newsPhotoLargeur)."' ".
							" WHERE news_id 		= '".mysqli_real_escape_string($connexion_db,$newsId)."';";
		$update_result 		= mysqli_query($connexion_db,$update_query);
		// -----------------
	}

} // fin TRAITEMENT PHOTO
// ---------------------------------------------------