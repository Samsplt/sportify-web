<?php
// j’inclus le header pour la nav
include 'header.php';
// je me connecte à la base de données
require_once 'includes/db.php';

// je récupère tous les coachs en évitant les doublons
$stmt = $pdo->query("
    SELECT nom_coach, photo, email, telephone, salle, description
    FROM disponibilities
    GROUP BY nom_coach
");
$coachs = $stmt->fetchAll();
?>

<div class="container my-5">
    <?php // bouton pour revenir à la page des services ?>
    <a href="services_salle.php" class="btn btn-outline-secondary mb-4">
        ← Retour aux services
    </a>

    <h2 class="text-center mb-4">Personnel de la salle de sport</h2>

    <?php if (count($coachs) > 0): ?>
        <div id="coachCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">

                <?php foreach ($coachs as $index => $coach): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="row justify-content-center">
                            <div class="col-md-6 text-center">
                                <?php // photo du coach avec style pour que ça rentre ?>
                                <img src="images_photos/coachs/<?= htmlspecialchars($coach['photo']) ?>" 
                                     alt="<?= htmlspecialchars($coach['nom_coach']) ?>" 
                                     class="d-block mx-auto img-fluid rounded mb-3"
                                     style="max-height: 300px; object-fit: contain;">
                                <?php // nom du coach ?>
                                <h5><?= htmlspecialchars($coach['nom_coach']) ?></h5>
                                <?php // salle où il travaille ?>
                                <p><strong>Salle :</strong> <?= htmlspecialchars($coach['salle']) ?></p>
                                <?php // numéro de téléphone ?>
                                <p><strong>Téléphone :</strong> <?= htmlspecialchars($coach['telephone']) ?></p>
                                <?php // email du coach ?>
                                <p><strong>Email :</strong> <?= htmlspecialchars($coach['email']) ?></p>
                                <?php 
                                // si le coach a mis une description, je l’affiche
                                if (!empty($coach['description'])): 
                                ?>
                                    <p class="fst-italic text-muted"><?= nl2br(htmlspecialchars($coach['description'])) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

            <?php // contrôles pour naviguer dans le carrousel ?>
            <button class="carousel-control-prev" type="button" data-bs-target="#coachCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#coachCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                <span class="visually-hidden">Suivant</span>
            </button>
        </div>
    <?php else: ?>
        <?php // si aucun coach n’est trouvé, je le dis ?>
        <p class="text-center text-muted">Aucun coach trouvé.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
