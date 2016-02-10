<?php
// © Jérome Réaux : http://j-reaux.developpez.com - http://www.jerome-reaux-creations.fr
// --------------------------------------------------------------
// Paramètres de connection a la Base de Données sur le serveur
// --------------------------------------------------------------
$connexion = array();
$connexion['hostname'] = 'localhost'; 		// voir hébergeur ou "localhost" en local
$connexion['database'] = 'news'; 	// nom de la BdD
$connexion['username'] = 'root'; 			// identifiant "root" en local
$connexion['password'] = ''; 				// mot de passe (vide en local)
// --------------------------------------------------------------
// connexion à la base de données
$connexion_db = 
	mysqli_connect($connexion['hostname'],$connexion['username'],$connexion['password'],$connexion['database']) 
	or die ('Erreur de paramètres de connexion à la BD');

mysqli_set_charset( $connexion_db,'utf8' ); // encodage UTF-8
// ------------------------
$connexion = array(); // on vide
// --------------------------------------------------------------
