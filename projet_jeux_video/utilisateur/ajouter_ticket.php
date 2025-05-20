<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();
    require_once '../donnee/db.php'; // Inclure la connexion à la base de données

    $error = ''; // Variable pour afficher les erreurs de connexion

    $assistance = $pdo->query("SELECT idOS, nom_service FROM assistance")->fetchAll();
?>

<form action="traitement.php" method="post">
    <!-- ... autres champs ... -->

    <label>Assistance :</label><br>
    <select name="idOS" required>
        <option value="">-- Choisir --</option>
        <?php foreach ($assistance as $a): ?>
            <option value="<?php echo $a['idOS'] ?>"><?php echo $a['nom_service'] ?> (ID:<?php echo $a['idOS'] ?>)</option>
        <?php endforeach; ?>
    </select><br><br>

    <input type="submit" value="Envoyer le ticket">
</form>
