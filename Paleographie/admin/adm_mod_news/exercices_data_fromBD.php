<?php 

if(is_numeric($newsId) && $newsId>0)
{
	// ---------------------
	// Récupération des champs dans la BD
	$news_fiche_query 		= "SELECT * FROM news_tab_articles ".
							" WHERE news_id = '".mysqli_real_escape_string($connexion_db,$newsId)."';";
//	$news_result 			= mysql_query($news_fiche_query) or die('Erreur SQL :<br />'.$news_fiche_query.'<br />'.mysql_error()); // TEST LOCAL
	$news_fiche_result 		= mysqli_query($connexion_db,$news_fiche_query);
	$news_fiche_row			= mysqli_fetch_array($news_fiche_result);
	// ---------------------
	$newsId 				= intval($news_fiche_row['news_id']);
	$newsTitre 				= ($news_fiche_row['news_titre']);
	$chapitre				=($news_fiche_row['chapitre']);
	$newsContenu 			= ($news_fiche_row['news_contenu']);	// texarea
	$transcription 			= ($news_fiche_row['transcription']);
	$newsDate 				= intval($news_fiche_row['news_date']);
	$newsPublier 			= ($news_fiche_row['news_publier']);
	// ---------------------
	// Photo
	$newsPhoto 				= ($news_fiche_row['news_photo']);
	$newsPhotoAvant			= $newsPhoto;
	$newsPhotoLargeur		= intval($news_fiche_row['news_photo_largeur']);
	// ---------------------
	// Fichier joint
	$newsFile 				= ($news_fiche_row['news_file']);
	$newsFileAvant			= $newsFile;

}
// ---------------------------------------------------
else {
	// ---------------------
	// Initialisation de l'Article (Ajouter)
	$newsId 				= 0;
	$newsTitre 				= '';
	$chapitre 				= '';
	$newsContenu 			= '';
	$transcription			= '';
	$newsDate 				= time(); 	// date du jour par défaut
	$newsPublier 			= 1;		// Publier : Oui
	// ---------------------
	// Photo
	$newsPhoto 				= '';
	$newsPhotoAvant			= '';
	$newsPhotoLargeur		= 300;		// par défaut
	// ---------------------
	// Fichier joint
	$newsFile 				= '';
	$newsFileAvant			= '';
}
// ---------------------------------------------------
