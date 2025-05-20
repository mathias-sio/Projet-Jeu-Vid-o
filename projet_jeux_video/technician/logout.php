<?php
session_start();
session_unset();   // Supprime toutes les variables de session
session_destroy(); // Détruit la session

// Redirection vers la page de login
header('Location: login.php');
exit();

//Depuis n’importe quelle page sécurisée (comme dashboard.php),
//on peut mettre un lien vers la déconnexion :

//<a href="logout.php" class="logout"> Déconnexion</a>

//Tu peux le styliser comme dans l’exemple du dashboard.php.

// Résultat :

//  Le technicien clique sur “Déconnexion”

//  Sa session est détruite

//    Il est automatiquement renvoyé vers la page de login
