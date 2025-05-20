<?php
$host         = 'localhost';
$dbname       = 'ma_bd';
$username     = 'Assane';
$mot_de_passe = 'btsinfo'; // Le mot de passe brut

// Crée une connexion PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", 'Assane', 'btsinfo');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Hache le mot de passe avant de l'insérer
    $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_BCRYPT);

    // Insertion d'un nouvel utilisateur
    $stmt = $pdo->prepare("INSERT INTO users (username, mot_de_passe) VALUES (?, ?)");
    $stmt->execute(['Assane', $mot_de_passe_hache]);

    echo "";  // "Utilisateur ajouté avec succès!";
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
