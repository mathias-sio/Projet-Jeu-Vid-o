<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();
    require_once '../donnee/db.php';

    $sql = "
    SELECT t.idT, t.nom, t.email, t.categorie, t.description, t.date_demande, t.statut, t.created_at, a.nom_service
    FROM tickets t
    INNER JOIN assistance a ON t.idOS = a.idOS
    ORDER BY t.created_at DESC
";
    $tickets = $pdo->query($sql)->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des tickets</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f4f8;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        thead {
            background-color: #005792;
            color: white;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #eef2f7;
        }

        th {
            font-size: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            color: #333;
            font-size: 14px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Liste des tickets</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Catégorie</th>
                <th>Description</th>
                <th>Assistance</th>
                <th>Date Demande</th>
                <th>Statut</th>
                <th>Créé le</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($tickets)): ?>
                <tr><td colspan="9">Aucun ticket trouvé.</td></tr>
            <?php else: ?>
<?php foreach ($tickets as $ticket): ?>
                    <tr>
                        <td>
                        <a href="consulter_ticket.php?id=<?php echo $ticket['idT']; ?>">
                        <?php echo $ticket['idT'] ?>
                        </a>
                        </td>
                        <td><?php echo htmlspecialchars($ticket['nom']) ?></td>
                        <td><?php echo htmlspecialchars($ticket['email']) ?></td>
                        <td><?php echo htmlspecialchars($ticket['categorie']) ?></td>
                        <td><?php echo nl2br(htmlspecialchars($ticket['description'])) ?></td>
                        <td><?php echo htmlspecialchars($ticket['nom_service']) ?></td>
                        <td><?php echo $ticket['date_demande'] ?></td>
                        <td><?php echo $ticket['statut'] ?></td>
                        <td><?php echo $ticket['created_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
<?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
