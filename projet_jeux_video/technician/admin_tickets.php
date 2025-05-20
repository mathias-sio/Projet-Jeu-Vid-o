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

    // Récupération des tickets
    $tickets = $pdo->query("SELECT * FROM tickets ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panneau Admin - Tickets</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: left; }
        button.statut-btn {
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            color: #fff;
        }
        .ouvert { background-color: #28a745; }
        .en-cours { background-color: #ffc107; }
        .ferme { background-color: #dc3545; }
    </style>
</head>
<body>
    <h1>Liste des Tickets</h1>
    <table>
        <tr>
            <th>ID</th><th>Nom</th><th>Email</th><th>Catégorie</th><th>Statut</th><th>Date</th>
        </tr>
        <?php foreach ($tickets as $ticket): ?>
<?php
    $class = str_replace(' ', '-', strtolower($ticket['statut'])); // Pour les classes CSS
?>
            <tr>
                <td><?php echo $ticket['idT'] ?></td>
                <td><?php echo htmlspecialchars($ticket['nom']) ?></td>
                <td><?php echo htmlspecialchars($ticket['email']) ?></td>
                <td><?php echo htmlspecialchars($ticket['categorie']) ?></td>
                <td>
                    <button class="statut-btn                                                                                           <?php echo $class ?>" data-id="<?php echo $ticket['idT'] ?>">
                        <?php echo $ticket['statut'] ?>
                    </button>
                </td>
                <td><?php echo $ticket['date_demande'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <script>
    document.querySelectorAll('.statut-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            fetch('changer_statut.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'id=' + id
            })
            .then(res => res.text())
            .then(newStatut => {
                this.textContent = newStatut;
                this.className = 'statut-btn ' + newStatut.toLowerCase().replace(' ', '-');
            })
            .catch(err => console.error('Erreur:', err));
        });
    });
    </script>
</body>
</html>
