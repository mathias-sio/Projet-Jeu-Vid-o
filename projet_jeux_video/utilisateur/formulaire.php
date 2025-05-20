<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();
    require_once '../donnee/db.php'; // Connexion à la base

    // Récupérer les options d'assistance
    $assistance = $pdo->query("SELECT idOS, nom_service FROM assistance")->fetchAll();
?>

<h2>Créer un nouveau ticket</h2>

<form action="traitement.php" method="post">
    <label>Nom :</label><br>
    <input type="text" name="nom" required><br><br>

    <label>Email :</label><br>
    <input type="email" name="email" required><br><br>

    <label>Catégorie :</label><br>
    <input type="text" name="categorie" required><br><br>

    <label>Description :</label><br>
    <textarea name="description" required></textarea><br><br>

    <label>Date de demande :</label><br>
    <input type="date" name="date_demande" required><br><br>

    <label>Assistance :</label><br>
    <select name="idOS" required>
        <option value="">-- Choisir --</option>
        <?php foreach ($assistance as $a): ?>
            <option value="<?php echo $a['idOS'] ?>"><?php echo htmlspecialchars($a['nom_service']) ?> (ID:<?php echo $a['idOS'] ?>)</option>
        <?php endforeach; ?>
    </select><br><br>

    <input type="submit" value="Envoyer le ticket">
</form>
