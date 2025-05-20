<?php
//Ajoute simplement en haut de chaque page que tu veux protéger côté
//technicien (comme dashboard.php, ticket.php, etc.)  require_once 'auth.php';

session_start();

// Vérifie si un technicien est connecté
if (! isset($_SESSION['technician'])) {
    // S'il n'est pas connecté, on le redirige vers la page de login
    header('Location: login.php');
    exit();
}
