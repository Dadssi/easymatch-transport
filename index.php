<?php
include_once 'dbgraph.php';
include_once 'Annonce.php';
include_once 'Demande.php';
include_once 'Transaction.php';

$database = new Database();
$db = $database->getConnection();

$annonce = new Annonce($db);
$demande = new Demande($db);
$transaction = new Transaction($db);

// Récupération des données
$totalAnnonces = $annonce->countAnnonces();
$totalDemandes = $demande->countDemandes();
$totalTransactions = $transaction->countTransactions();

// Encoder les données en JSON
$data = json_encode([
    'annonces' => $totalAnnonces,
    'demandes' => $totalDemandes,
    'transactions' => $totalTransactions,
]);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Conteneur principal */
        .charts-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
        }
        /* Conteneur de chaque graphique */
        .chart {
            width: 300px;
            height: 300px;
        }
    </style>
</head>
<body>
    <div class="charts-container">
        <!-- Graphique des Annonces -->
        <div class="chart">
            <canvas id="annoncesChart"></canvas>
        </div>
        <!-- Graphique des Demandes -->
        <div class="chart">
            <canvas id="demandesChart"></canvas>
        </div>
        <!-- Graphique des Transactions -->
        <div class="chart">
            <canvas id="transactionsChart"></canvas>
        </div>
    </div>

    <script>
        const data = <?php echo $data; ?>;

        // Graphique des Annonces
        const ctxAnnonces = document.getElementById('annoncesChart').getContext('2d');
        new Chart(ctxAnnonces, {
            type: 'line',
            data: {
                labels: ['Annonces'],
                datasets: [{
                    data: [data.annonces],
                    backgroundColor: ['rgba(255, 99, 132, 0.2)'],
                    borderColor: ['rgba(255, 99, 132, 1)'],
                    borderWidth: 1
                }]
            }
        });

        // Graphique des Demandes
        const ctxDemandes = document.getElementById('demandesChart').getContext('2d');
        new Chart(ctxDemandes, {
            type: 'line',
            data: {
                labels: ['Demandes'],
                datasets: [{
                    data: [data.demandes],
                    backgroundColor: ['rgba(54, 162, 235, 0.2)'],
                    borderColor: ['rgba(54, 162, 235, 1)'],
                    borderWidth: 1
                }]
            }
        });

        // Graphique des Transactions
        const ctxTransactions = document.getElementById('transactionsChart').getContext('2d');
        new Chart(ctxTransactions, {
            type: 'line',
            data: {
                labels: ['Transactions'],
                datasets: [{
                    data: [data.transactions],
                    backgroundColor: ['rgba(75, 192, 192, 0.2)'],
                    borderColor: ['rgba(75, 192, 192, 1)'],
                    borderWidth: 1
                }]
            }
        });
    </script>
</body>
</html>
