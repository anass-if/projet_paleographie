<?php @session_start();
// © Jérome Réaux : http://j-reaux.developpez.com - http://www.jerome-reaux-creations.fr
// -----------------------------------------------------------
// Connection a la partie "Administration"
// -----------------------------------------------------------
// Paramètres Connexion ADMINISTRATION
$_SESSION['Admin']['Valid']		= false;
// -------------------------
	$login 						= isset($_POST['login'])? 	formatage_from_post($_POST['login']) : '';
	$pass 						= isset($_POST['pass'])? 	formatage_from_post($_POST['pass']) : '';
	$msgerreur 					= '';
// -------------------------
// si le visiteur (administrateur ?) a validé le formulaire
// on recupere les donnees
if ($login!='' && $pass!='')
{
	// -------------------------
	// ==> CONFIGURATION de VOS paramètres de connexion PERSO
	// ==> login et mot de passe de l'ADMINISTRATEUR :
   $AdminIdentifiant 			= 'Newslogin';		// A REMPLACER !!
   $AdminMotDePasse 			= 'Newspwd';		// A REMPLACER !!
	// --------------------
	if ($login == $AdminIdentifiant && $pass == $AdminMotDePasse) 
	{
		// Si le login et le mot de passe sont corrects
		// on met true dans une variable de session
		$_SESSION['Admin']['Valid'] = true;   
	// --------------------
	} else {
		$_SESSION['Admin']['Valid'] = false;
		$msgerreur = 'Identifiant ou Mot de passe incorrect';
	}
}
// -------------------------
// Accès autorisé si identifié
if ($_SESSION['Admin']['Valid']==true)
{  
   // Redirection vers la page d administration des News
   header('location: ./adm_mod_news/news_liste.php');
   exit;
}
// -------------------------
