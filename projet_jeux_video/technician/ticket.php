<?php
    session_start();
    require_once 'auth.php';
    require_once './bd/bd.php';

    // Vérifie si un ID est passé dans l'URL
    if (! isset($_GET['id']) || empty($_GET['idT'])) {
        die('Aucun ticket sélectionné.');
    }

    $idT = intval($_GET['idT']);

    // Mise à jour du statut si formulaire soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
        $newStatus = $_POST['status'];
        $stmt      = $pdo->prepare("UPDATE tickets SET status = ? WHERE idT = ?");
        $stmt->execute([$newStatus, $id]);

        // Redirection pour éviter le resoumission du formulaire
        header("Location: ticket.php?idT=$idT");
        exit();
    }

    // Récupération du ticket
    $stmt = $pdo->prepare("SELECT * FROM tickets WHERE idT = ?");
    $stmt->execute([$idT]);
    $ticket = $stmt->fetch();

    if (! $ticket) {
        die("Ticket non trouvé.");
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail du ticket #<?php echo $ticket['idT'] ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }

        .container {
            background: white;
            max-width: 700px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        p {
            line-height: 1.5;
        }

        label {
            font-weight: bold;
        }

        select, input[type="submit"] {
            padding: 10px;
            margin-top: 10px;
            width: 100%;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        .back {
            margin-top: 20px;
            display: block;
            text-align: center;
        }

    </style>
</head>
<body>

<div class="container">
    <h2>Ticket #<?php echo $ticket['idT'] ?></h2>

    <p><strong>Titre :</strong>                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php echo htmlspecialchars($ticket['title']) ?></p>
    <p><strong>categorie :</strong>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php echo htmlspecialchars($ticket['category']) ?></p>
    <p><strong>Description :</strong><br><?php echo nl2br(htmlspecialchars($ticket['description'])) ?></p>
    <p><strong>Date de création :</strong>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php echo date('d/m/Y H:i', strtotime($ticket['created_at'])) ?></p>
    <p><strong>Statut actuel :</strong> <em><?php echo $ticket['status'] ?></em></p>

    <form method="POST">
        <label for="status">Modifier le statut :</label>
        <select name="status" id="status" required>
            <option value="ouvert"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php echo $ticket['status'] == 'ouvert' ? 'selected' : '' ?>>Ouvert</option>
            <option value="en cours"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php echo $ticket['status'] == 'en cours' ? 'selected' : '' ?>>En cours</option>
            <option value="fermé"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php echo $ticket['status'] == 'fermé' ? 'selected' : '' ?>>Fermé</option>
        </select>

        <input type="submit" value="Mettre à jour le statut">
    </form>

    <a class="back" href="dashboard.php">Retour au tableau de bord</a>
</div>

    <!-- Résumé du fonctionnement

    L’URL est comme : ticket.php?id=3

    Le ticket est récupéré en BDD grâce à son id

    Le technicien peut changer son statut via un <select>

    Le changement est appliqué en base de données avec une redirection (PRG pattern) -->


</body>
</html>


