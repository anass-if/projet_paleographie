<?php	

// ADMIN FONCTIONS
	include("_connexion.php");
	require('_protect_page.php');
	require_once('../adm_mod_news/fonction/fct_traitement_image.php');
// Chemin des dossiers 
if(!defined('NEWS_REP_PHOTOS')) 		define('NEWS_REP_PHOTOS', 		'upload/images/news_photos/');		// PHOTOS
if(!defined('NEWS_EXTENSION_PHOTO')) 	define('NEWS_EXTENSION_PHOTO',	'jpg,jpeg,png,gif');
if(!defined('NEWS_MIMETYPE_PHOTO')) 	define('NEWS_MIMETYPE_PHOTO',	'image/jpeg,image/png,image/gif');
// -------------------------
// UPLOAD : Restrictions sur les fichiers
// taille maxi des fichiers
if(!defined('NEWS_SIZEMAX_PHOTO')) 		define('NEWS_SIZEMAX_PHOTO', 	10000000);	// 10 Mo

// FICHIER joint

if(!defined('NEWS_REP_FILES')) 			define('NEWS_REP_FILES', 		'upload/files/news_files/');		// FICHIERS
if(!defined('NEWS_MIMETYPE_FILE')) 		define('NEWS_MIMETYPE_FILE',	'application/pdf');
if(!defined('NEWS_SIZEMAX_FILE')) 		define('NEWS_SIZEMAX_FILE',		10000000);	// 10 Mo
if(!defined('NEWS_EXTENSION_FILE')) 	define('NEWS_EXTENSION_FILE',	'pdf');

// DOSSIER des ICONES (administration)
if(!defined('REP_ADM_ICONES')) 				define('REP_ADM_ICONES', 		'../icones/');

