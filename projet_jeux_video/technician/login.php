<?php
    error_reporting(E_ALL);       // Affiche toutes les erreurs
    ini_set('display_errors', 1); // Les affiche à l'écran

    session_start();
    require_once '../donnee/db.php'; // Inclure la connexion à la base de données

    $error = ''; // Variable pour afficher les erreurs de connexion

    // Vérifie si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                                                               // Récupère les données envoyées par le formulaire
        $username     = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; // Utilisateur (username)
        $mot_de_passe = isset($_POST['mot_de_passe']) ? $_POST['mot_de_passe'] : '';           // Mot de passe

        // Vérifie si les champs ne sont pas vides
        if (! empty($username) && ! empty($mot_de_passe)) {
            // Prépare la requête pour récupérer l'utilisateur depuis la base de données
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(); // Récupère les données de l'utilisateur

            // Si l'utilisateur existe et que le mot de passe est correct
            if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
                                                             // Si la vérification du mot de passe est réussie
                $_SESSION['technicien'] = $user['username']; // Crée une session pour l'utilisateur
                header('Location: dashboard.php');           // Redirige vers le tableau de bord
                exit();
            } else {
                // Si le mot de passe ou le nom d'utilisateur est incorrect
                $error = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        } else {
            $error = "Veuillez remplir tous les champs."; // Affiche une erreur si un champ est vide
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Technicien</title>
    <style>
        body {
            background: linear-gradient(135deg, #1d3557, #457b9d);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        form {
            background: #f1faee;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            margin-bottom: 25px;
            text-align: center;
            color: #1d3557;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #1d3557;
        }

        input[type="text"], input[type="mot_de_passe"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #457b9d;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #1d3557;
        }

        .error {
            background-color: #e63946;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<form method="POST" action="">
    <h2>Connexion Technicien</h2>

    <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <label for="username">Nom d'utilisateur :</label>
    <input type="text" name="username" id="username" required>

    <label for="mot_de_passe">Mot de passe :</label>
    <input type="password" name="mot_de_passe" id="mot_de_passe" required>

    <input type="submit" value="Se connecter">
</form>

</body>
</html>
