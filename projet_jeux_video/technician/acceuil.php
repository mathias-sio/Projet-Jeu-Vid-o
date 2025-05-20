<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();
    require_once '../donnee/db.php';

    // Récupérer la recherche et le statut filtré
    $search       = $_GET['search'] ?? '';
    $filtreStatut = $_GET['statut'] ?? '';

    // Requête dynamique
    $params = [];
    $where  = [];

    if (! empty($search)) {
        $where[]          = '(t.nom LIKE :search OR t.description LIKE :search)';
        $params['search'] = '%' . $search . '%';
    }

    if (! empty($filtreStatut)) {
        $where[]          = 't.statut = :statut';
        $params['statut'] = $filtreStatut;
    }

    $sql = "
    SELECT t.*, a.nom_service
    FROM tickets t
    INNER JOIN assistance a ON t.idOS = a.idOS
";

    if ($where) {
        $sql .= ' WHERE ' . implode(' AND ', $where);
    }

    $sql .= ' ORDER BY a.nom_service, t.created_at DESC';

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $tickets = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Tickets</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 30px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .w3-purple {
            text-align: center;
            margin-bottom: 30px;
        }

        .filters input, .filters select {
            padding: 8px 12px;
            font-size: 14px;
            margin: 0 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .filters button {
            padding: 8px 14px;
            background-color: #005792;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .service-block {
            background: #fff;
            margin-bottom: 30px;
            padding: 20px;
            border-left: 5px solid #005792;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .service-title {
            margin: 0 0 15px 0;
            font-size: 20px;
            color: #005792;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .ticket {
            margin-bottom: 15px;
            padding: 12px;
            border-radius: 6px;
            background: #f9f9f9;
            border-left: 4px solid #ccc;
        }

        .ticket-title {
            font-weight: bold;
            margin-bottom: 6px;
        }

        .ticket-status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            color: white;
        }

        .statut-ouvert { background-color: #28a745; }
        .statut-en-cours { background-color: #ffc107; }
        .statut-ferme { background-color: #dc3545; }

        .ticket-date {
            font-size: 12px;
            color: #666;
            margin-top: 4px;
        }

        .no-ticket {
            color: #777;
            font-style: italic;
        }

        .counter {
            font-size: 13px;
            color: #777;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<h1 class="w3-blue">Panneau d’accueil - Tickets par type d’assistance</h1>

<div class="w3-purple">
    <form method="get">
        <input type="text" name="search" placeholder="Rechercher un ticket..." value="<?php echo htmlspecialchars($search) ?>">
        <select name="statut">
            <option value="">-- Tous les statuts --</option>
            <option value="ouvert"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php echo $filtreStatut == 'ouvert' ? 'selected' : '' ?>>Ouvert</option>
            <option value="en cours"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php echo $filtreStatut == 'en cours' ? 'selected' : '' ?>>En cours</option>
            <option value="fermé"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php echo $filtreStatut == 'fermé' ? 'selected' : '' ?>>Fermé</option>
        </select>
        <button type="submit">Filtrer</button>
    </form>
</div>

<?php foreach ($tickets as $service => $ticketsDuService): ?>
    <div class="service-block">
        <h2 class="service-title"><?php echo htmlspecialchars($service) ?></h2>
        <div class="counter"><?php echo count($ticketsDuService) ?> ticket(s)</div>

        <?php foreach ($ticketsDuService as $ticket): ?>
<?php
    $statut      = strtolower($ticket['statut']);
    $classStatut = match ($statut) {
        'ouvert' => 'statut-ouvert',
        'en cours' => 'statut-en-cours',
        'fermé' => 'statut-ferme',
        default => '',
    };
?>
            <div class="ticket">
                <div class="ticket-title"><?php echo htmlspecialchars($ticket['nom']) ?></div>
                <div><?php echo htmlspecialchars(mb_strimwidth($ticket['description'], 0, 100, '...')) ?></div>
                <div class="ticket-date">Date :                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php echo $ticket['date_demande'] ?></div>
                <div class="ticket-status                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php echo $classStatut ?>"><?php echo $ticket['statut'] ?></div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

<?php if (empty($tickets)): ?>
    <p class="no-ticket">Aucun ticket ne correspond à vos critères.</p>
<?php endif; ?>

</body>
</html>
