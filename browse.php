<?php include 'header.php'; ?>

<?php
// je récupère la catégorie dans l’URL ou je la laisse vide
$cat = $_GET['cat'] ?? '';
// je mets un titre par défaut
$titre = 'Tout Parcourir';
// je prépare un tableau vide pour les sports
$sports = [];

// selon la catégorie, je définis le titre et la liste des sports
switch ($cat) {
    case 'activites':
        // si c’est activites, j’affiche les activités sportives
        $titre = 'Activités sportives';
        $sports = [
            'musculation' => 'Musculation.jpg',
            'fitness' => 'Fitness.jpg',
            'biking' => 'Biking.jpeg',
            'cardio-training' => 'cardiotraining.jpg',
            'cours collectif' => 'courscollectifs.jpg'
        ];
        break;

    case 'competition':
        // si c’est competition, j’affiche les sports de compétition
        $titre = 'Sports de compétition';
        $sports = [
            'football' => 'football.jpg',
            'rugby' => 'rugby.jpg',
            'basketball' => 'basket.jpeg',
            'tennis' => 'tennis.jpg',
            'natation' => 'natation.jpg',
            'plongeon' => 'plongeon.jpg'
        ];
        break;

    case 'salle':
        // si c’est salle, j’affiche la salle de sport Omnes
        $titre = 'Salle de sport Omnes';
        break;

    default:
        // sinon, je reste sur Tout Parcourir
        $titre = 'Tout Parcourir';
        break;
}
?>

<div class="container mt-5 text-center">
    <!-- j’affiche le titre de la page -->
    <h2 class="mb-4"><?= htmlspecialchars($titre) ?></h2>

    <?php if ($cat === 'salle'): ?>
        <!-- si la catégorie est salle, je montre les infos de la salle -->
        <div class="card shadow mx-auto d-flex flex-row" style="max-width: 900px;">
            <div class="p-3" style="width: 50%;">
                <!-- image de la salle -->
                <img src="images_photos/salle.jpg" alt="Salle de sport Omnes" class="img-fluid rounded">
            </div>
            <div class="card-body text-start" style="width: 50%;">
                <!-- détails de la salle Basic Fit Paris 15 -->
                <h4 class="card-title">Basic Fit Paris 15</h4>
                <p class="card-text">
                    <strong>Adresse :</strong> 133 Rue de Javel, 75015 Paris<br>
                    <strong>Téléphone :</strong>  03 66 33 33 44<br>
                    <strong>Email :</strong> contact@basicfitparis15.fr<br>
                    <strong>Horaires :</strong> 6h - 19h (7j/7)
                </p>
                <!-- bouton vers la page des services de la salle -->
                <a href="services_salle.php" class="btn btn-primary mt-2">Nos services</a>
            </div>
        </div>

    <?php elseif (!empty($sports)): ?>
        <!-- si j’ai une liste de sports, je les affiche en cartes -->
        <div class="row justify-content-center text-center">
            <?php foreach ($sports as $nom => $image): ?>
                <div class="col-md-4 mb-4">
                    <div class="card p-3 shadow">
                        <!-- image du sport -->
                        <img src="images_photos/<?= htmlspecialchars($image) ?>" class="img-fluid mb-3" alt="<?= htmlspecialchars($nom) ?>">
                        <!-- nom du sport avec première lettre en majuscule -->
                        <h4><?= ucfirst($nom) ?></h4>
                        <!-- lien vers la page de détail du sport -->
                        <a href="sport_detail.php?sport=<?= urlencode($nom) ?>&cat=<?= urlencode($cat) ?>" class="btn btn-outline-primary mt-2"><?= ucfirst($nom) ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <!-- si rien à afficher, je le signale à l’utilisateur -->
        <p class="text-muted">Aucune activité à afficher pour cette catégorie.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
