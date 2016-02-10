<?php

	include("_connexion.php");
// -----------------------------------------------------------
// Paramètres Connexion ADMINISTRATION
$_SESSION['Admin']['Valid']		= false;
$_SESSION['Admin']['Statut']	= '';
$_SESSION['Admin']['Pseudo']	= '';
$msgerreur 						= '';
// -------------------------
// si le visiteur (administrateur ?) a validé le formulaire
// on recupere les donnees
if (isset($_POST['login']) && $_POST['login']!='' && isset($_POST['pass']) && $_POST['pass']!='')
{
	// --------------
	// Recherche en Base de données :
	$auth_query 	= " SELECT CNX.log_admin, CNX.controle, CNX.id_statut, CNX.nom_admin, CNX.prenom_admin ".
					" FROM NEWS_ADM_CONNEXION AS CNX ".
					" WHERE CNX.log_admin = '".mysqli_real_escape_string($connexion_db,$_POST['login'])."' ".
					" AND CNX.id_statut > 1 ; ";
//	$auth_result 	= mysql_query($auth_query) or die('Erreur SQL :<br />'.$auth_query.'<br />'.mysql_error()); // TEST LOCAL
	$auth_result 	= mysqli_query($connexion_db,$auth_query);
	$auth_nombre 	= mysqli_num_rows($auth_result);
	$auth_row		= mysqli_fetch_array($auth_result);
	// --------------
	// si on trouve bien un login dans la BD
	if ($auth_nombre==1) {
		// on verifie la validite du mot de passe
		if ($auth_row['controle']==$_POST['pass'])
		{
			// IDENTIFICATION OK
			$_SESSION['Admin']['Valid'] 	= true;						// VALIDATION (-> true)
			$_SESSION['Admin']['Statut'] 	= $auth_row['id_statut'];	// STATUT (niveau d'acces)
			// Pseudo (Nom-Prenom, ou login)
		  if($auth_row['nom_admin']=='' && $auth_row['prenom_admin']=='') {
			$_SESSION['Admin']['Pseudo'] 	= $auth_row['log_admin'];
		  } else {
			$_SESSION['Admin']['Pseudo'] 	= $auth_row['prenom_admin'].' '.$auth_row['nom_admin'];
		  }
		} else {
			// mauvais pwd
			$_SESSION['Admin']['Valid'] 	= false;
			$msgerreur = 'Identifiant ou Mot de passe incorrect';
			$_SESSION['Admin']['Statut'] 	= '';
			$_SESSION['Admin']['Pseudo'] 	= '';

		}
	// --------------
	} else {
			// mauvais login
			$_SESSION['Admin']['Valid'] 	= false;
			$msgerreur = 'Identifiant ou Mot de passe incorrect';
			$_SESSION['Admin']['Statut'] 	= '';
			$_SESSION['Admin']['Pseudo'] 	= '';
	}
}
// ---------------------------------------------------------------
// Accès autorisé si identifié :
if (isset($_SESSION['Admin']['Valid']) && $_SESSION['Admin']['Valid']==true)
{  
   // Redirection vers la page d administration des News
   header('location: ./adm_mod_news/gestion.php');
}

// ---------------------------------------------------------------
// sinon affichage du formulaire d'identification
