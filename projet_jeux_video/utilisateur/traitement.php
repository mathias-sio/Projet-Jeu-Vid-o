<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../donnee/db.php'; // Connexion à la base

try {
    // Vérifie que toutes les données attendues sont présentes
    if (
        isset($_POST['nom']) &&
        isset($_POST['email']) &&
        isset($_POST['categorie']) &&
        isset($_POST['description']) &&
        isset($_POST['date_demande']) &&
        isset($_POST['idOS']) &&
        ! empty($_POST['idOS'])
    ) {
        // Récupération et sécurisation des données
        $nom          = htmlspecialchars(trim($_POST['nom']));
        $email        = htmlspecialchars(trim($_POST['email']));
        $categorie    = htmlspecialchars(trim($_POST['categorie']));
        $description  = htmlspecialchars(trim($_POST['description']));
        $date_demande = $_POST['date_demande'];
        $idOS         = intval($_POST['idOS']); // Sécurise en nombre entier

        // Préparation de la requête SQL
        $stmt = $pdo->prepare("
            INSERT INTO tickets (nom, email, categorie, description, date_demande, idOS)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$nom, $email, $categorie, $description, $date_demande, $idOS]);

        echo "✅ Ticket ajouté avec succès.";
    } else {
        echo "❌ Erreur : tous les champs obligatoires ne sont pas remplis.";
    }
} catch (PDOException $e) {
    echo "❌ Erreur lors de l'ajout du ticket : " . $e->getMessage();
}
