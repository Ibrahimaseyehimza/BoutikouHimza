<?php
// Démarrer la session
session_start();

// Détruire toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Rediriger l'utilisateur vers la page de connexion ou la page d'accueil
header("Location: ../index.php?=");  // Par exemple, rediriger vers la page d'accueil
exit();
?>