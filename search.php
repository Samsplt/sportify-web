<?php
// on inclut le fichier de connexion à la base de données
require_once 'includes/db.php';
// on inclut le header pour afficher la barre de nav
include 'header.php';

// on récupère le mot-clé passé en GET ou on initialise à vide
$keyword = $_GET['q'] ?? '';
$results_coachs = [];
$results_services = [];

if ($keyword) {
    // on prépare le mot-clé pour la requête LIKE
    $like = "%$keyword%";

    // on cherche les coachs dont le nom, le sport ou la salle correspond au mot-clé
    $stmt = $pdo->prepare("
        SELECT * FROM disponibilities 
        WHERE nom_coach LIKE ? OR sport LIKE ? OR salle LIKE ?
        GROUP BY nom_coach
    ");
    $stmt->execute([$like, $like, $like]);
    $results_coachs = $stmt->fetchAll();

    // on définit les différentes sections de services de la salle
    $sections = [
        'regles' => 'Règles sur l’utilisation des machines',
        'nutrition' => 'Alimentation et nutrition',
        'nouveaux' => 'Nouveaux clients',
        'horaire' => 'Horaire de la gym',
        'personnel' => 'Personnels de la salle de sport'
    ];

    // on vérifie pour chaque section si le mot-clé s’y trouve
    foreach ($sections as $id => $label) {
        if (stripos($label, $keyword) !== false || stripos($id, $keyword) !== false || stripos($keyword, $id) !== false) {
            $results_services[] = [
                'id' => $id,
                'label' => $label
            ];
        }
    }
}
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">🔍 Rechercher un coach, un service ou une spécialité</h2>

    <form method="GET" class="d-flex justify-content-center mb-5">
        <!-- champ de recherche pour le mot-clé -->
        <input type="text" name="q" class="form-control form-control-lg rounded-start-pill w-50 shadow-sm" placeholder="Nom, sport, nutrition, règles..." value="<?= htmlspecialchars($keyword) ?>">
        <!-- bouton pour lancer la recherche -->
        <button type="submit" class="btn btn-warning btn-lg rounded-end-pill px-4 fw-bold">Rechercher</button>
    </form>

    <?php if ($keyword): ?>
        <!-- on affiche le mot-clé recherché -->
        <h4 class="mb-3">Résultats pour <mark><?= htmlspecialchars($keyword) ?></mark> :</h4>

        <?php if (empty($results_coachs) && empty($results_services)): ?>
            <!-- si aucun résultat trouvé -->
            <div class="alert alert-warning">Aucun résultat trouvé.</div>
        <?php endif; ?>

        <?php if (!empty($results_coachs)): ?>
            <h5 class="text-primary">👤 Coachs trouvés</h5>
            <div class="row mb-4">
                <?php foreach ($results_coachs as $coach): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <!-- photo du coach ou image par défaut -->
                            <img src="images_photos/coachs/<?= htmlspecialchars($coach['photo'] ?? 'default.jpg') ?>" class="card-img-top" alt="<?= htmlspecialchars($coach['nom_coach']) ?>" style="height: 250px; object-fit: cover;">
                            <div class="card-body">
                                <!-- on affiche le nom du coach -->
                                <h5 class="card-title"><?= htmlspecialchars($coach['nom_coach']) ?></h5>
                                <p class="card-text">
                                    <!-- on affiche le sport, la salle, l’email et le téléphone -->
                                    <strong>Sport :</strong> <?= htmlspecialchars($coach['sport']) ?><br>
                                    <strong>Salle :</strong> <?= htmlspecialchars($coach['salle']) ?><br>
                                    <strong>Email :</strong> <?= htmlspecialchars($coach['email']) ?><br>
                                    <strong>Téléphone :</strong> <?= htmlspecialchars($coach['telephone']) ?>
                                </p>
                                <!-- lien vers la page de détails du sport -->
                                <a href="sport_detail.php?sport=<?= urlencode($coach['sport']) ?>" class="btn btn-outline-primary w-100">Voir les détails</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($results_services)): ?>
            <h5 class="text-success">🏋️‍♂️ Services de la salle Omnes</h5>
            <ul class="list-group list-group-flush mb-5">
                <?php foreach ($results_services as $s): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <!-- affichage du nom du service -->
                        <?= htmlspecialchars($s['label']) ?>
                        <!-- lien vers la section correspondante sur la page des services -->
                        <a href="services_salle.php#<?= $s['id'] ?>" class="btn btn-sm btn-success">Voir</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    <?php endif; ?>
</div>

<?php
// on inclut le footer pour fermer le HTML
include 'footer.php';
