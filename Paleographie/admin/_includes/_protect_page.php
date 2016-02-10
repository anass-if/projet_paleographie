<?php session_start();
// © Jérome Réaux : http://j-reaux.developpez.com - http://www.jerome-reaux-creations.fr
// --------------------------------------------------------------
// Protection des pages de la partie "administration"
// --------------------------------------------------------------
// si non identifie
if (!isset($_SESSION['Admin']['Valid']) || $_SESSION['Admin']['Valid']!=true)
{
   // redirection vers le formulaire d identification
   header('location: '.dirname(__DIR__) . '/index.php');
   exit;
}

// ------------------------------
// si identifie, on continue ...
// ------------------------------
