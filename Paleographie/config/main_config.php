<?php
// © Jérome Réaux : http://j-reaux.developpez.com - http://www.jerome-reaux-creations.fr
// ---------------------------------------------------------------
// CONFIGURATION GENERALE
// ---------------------------------------------------------------
// CHEMINS vers les DOSSIERS 	=> INDIQUEZ LE CHEMIN CORRECT !
//if(!defined('NEWS_ROOT')) 		define('NEWS_ROOT', 		'http://www.jerome-reaux-creations.fr/DVP/PHP-GESTION-NEWS-V4/'); // (site démo)
//if(!defined('NEWS_ROOT')) 		define('NEWS_ROOT', 		'http://localhost:8080/DVP-TUTOS/PHP-GESTION-NEWS-v4-MYSQL-Procedural/'); // EN LOCAL !
if(!defined('NEWS_ROOT')) 			define('NEWS_ROOT', 		'http://www.nom-du-site.com/dossier-news/'); // EN PRODUCTION : chemin absolu vers le dossier des news
if(!defined('NEWS_FONCTIONS')) 		define('NEWS_FONCTIONS', 	'fonctions/');
if(!defined('NEWS_MODULES')) 		define('NEWS_MODULES', 		'modules/');
if(!defined('NEWS_ADMIN')) 			define('NEWS_ADMIN', 		'admin/');
if(!defined('NEWS_UPLOAD')) 		define('NEWS_UPLOAD', 		'upload/');

// Remarque : NEWS_ROOT ne sert que pour les images et les liens des NEWS

// ---------------------------------------------------------------
// FICHE de la News 			=> INDIQUEZ LE CHEMIN CORRECT !
if(!defined('NEWS_PATH_FICHE')) 	define('NEWS_PATH_FICHE', 	'./index_news_fiche.php');	// demo
//if(!defined('NEWS_PATH_FICHE')) 	define('NEWS_PATH_FICHE', 	'http://www.nom-du-site.com/votre-news-fiche.php');  // EN PRODUCTION : chemin absolu du fichier contenant la FICHE de la news

// ---------------------------------------------------------------
// MODULE des NEWS
// ---------------------------------------------------------------
// PATH du module de News (depuis le NEWS_ROOT)
if(!defined('NEWS_MOD_NEWS')) 		define('NEWS_MOD_NEWS', 	NEWS_MODULES.'mod_news/');
// PATH du module de News ADMIN (depuis le NEWS_ROOT)
if(!defined('NEWS_MOD_ADM')) 		define('NEWS_MOD_ADM', 		NEWS_ADMIN.'adm_mod_news/');

// ---------------------------------------------------------------
// DOSSIER des ICONES (site)
if(!defined('NEWS_IMG_ICONES')) 	define('NEWS_IMG_ICONES', 	NEWS_ROOT.'template/img/icones/');
// ---------------------------------------------------------------
