<?php
    // Connexion à la base de données
    $host         = 'localhost';
    $dbname       = 'ma_bd';
    $username     = 'Assane';
    $mot_de_passe = 'btsinfo';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $mot_de_passe);
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    $erreur  = '';
    $success = '';

    // Traitement du formulaire
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom   = trim($_POST['nom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $mdp   = $_POST['mot_de_passe'] ?? '';

        if (! $nom || ! $email || ! $mdp) {
            $erreur = "Tous les champs sont obligatoires.";
        } elseif (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erreur = "Email invalide.";
        } else {
            // Hash du mot de passe
            $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

            // Insertion dans la base
            $stmt = $pdo->prepare("INSERT INTO techniciens (nom, email, mot_de_passe) VALUES (?, ?, ?)");
            try {
                $stmt->execute([$nom, $email, $mdp_hash]);
                $success = "Compte technicien créé avec succès.";
            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 1062) {
                    $erreur = "Un technicien avec cet email existe déjà.";
                } else {
                    $erreur = "Erreur lors de l'enregistrement : " . $e->getMessage();
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un compte Technicien</title>
    <style>
        form { max-width: 400px; margin: auto; }
        input { display: block; margin-bottom: 10px; padding: 8px; width: 100%; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Créer un compte Technicien</h2>

    <?php if ($erreur): ?>
        <p class="error"><?php echo htmlspecialchars($erreur); ?></p>
    <?php elseif ($success): ?>
        <p class="success"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nom :</label>
        <input type="text" name="nom" required>

        <label>Email :</label>
        <input type="email" name="email" required>

        <label>Mot de passe :</label>
        <input type="password" name="mot_de_passe" required>

        <button type="submit">Créer le compte</button>
    </form>
</body>
</html>
