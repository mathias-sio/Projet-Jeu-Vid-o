<?php
$host         = 'localhost';
$dbname       = 'ma_bd';
$username     = 'Assane';
$mot_de_passe = 'btsinfo';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $mot_de_passe);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Lire le statut actuel
    $stmt = $pdo->prepare("SELECT statut FROM tickets WHERE idT = ?");
    $stmt->execute([$id]);
    $current = $stmt->fetchColumn();

    // Liste des statuts
    $statuts   = ['ouvert', 'en cours', 'fermé'];
    $index     = array_search($current, $statuts);
    $newStatut = $statuts[($index + 1) % count($statuts)];

    // Mise à jour
    $update = $pdo->prepare("UPDATE tickets SET statut = ? WHERE idT = ?");
    $update->execute([$newStatut, $id]);

    echo $newStatut;
}
