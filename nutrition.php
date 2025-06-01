<?php
// on inclut le header pour afficher la nav
include 'header.php';
?>

<div class="container mt-5">
    <!-- titre principal de la page -->
    <h2 class="text-center mb-5">Alimentation &amp; Nutrition</h2>

    <div class="row g-4">

        <?php // section Introduction ?>
        <div class="col-md-6">
            <div class="card shadow h-100">
                <?php // en-tête de carte pour l’introduction ?>
                <div class="card-header bg-success text-white fw-semibold">
                    Introduction à la nutrition sportive
                </div>
                <div class="card-body">
                    <?php // texte expliquant l’importance de la nutrition ?>
                    <p>
                        L'alimentation est un pilier fondamental de toute pratique sportive. Elle influence vos performances,
                        votre récupération et vos résultats à long terme. Une nutrition adaptée permet de maximiser les efforts
                        réalisés en salle ou sur le terrain.
                    </p>
                    <?php // liste des macronutriments et leurs rôles ?>
                    <p>
                        Les macronutriments jouent un rôle essentiel :
                        <ul>
                            <li><strong>Protéines</strong> : récupération musculaire</li>
                            <li><strong>Glucides</strong> : énergie immédiate</li>
                            <li><strong>Lipides</strong> : fonctionnement hormonal</li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>

        <?php // section Conseils avant/après entraînement ?>
        <div class="col-md-6">
            <div class="card shadow h-100">
                <?php // en-tête de carte pour conseils pré/post séance ?>
                <div class="card-header bg-info text-white fw-semibold">
                    Conseils avant / après l'entraînement
                </div>
                <div class="card-body">
                    <?php // suggestions de repas avant l’entraînement ?>
                    <p><strong>Avant l'entraînement :</strong></p>
                    <ul>
                        <li>Porridge + banane</li>
                        <li>Riz complet + œufs</li>
                        <li>Fruits secs + yaourt</li>
                    </ul>
                    <?php // suggestions de repas après l’entraînement ?>
                    <p><strong>Après l'entraînement :</strong></p>
                    <ul>
                        <li>Blanc de poulet + quinoa</li>
                        <li>Shake protéiné + banane</li>
                        <li>Omelette + légumes vapeur</li>
                    </ul>
                </div>
            </div>
        </div>

        <?php // section Plans alimentaires selon les objectifs ?>
        <div class="col-md-6">
            <div class="card shadow h-100">
                <?php // en-tête de carte pour les plans alimentaires ?>
                <div class="card-header bg-primary text-white fw-semibold">
                    Plans alimentaires selon vos objectifs
                </div>
                <div class="card-body">
                    <?php // plan pour perte de poids ?>
                    <p><strong>🔥 Perte de poids :</strong> Réduction des glucides rapides, portions équilibrées.</p>
                    <?php // plan pour prise de masse ?>
                    <p><strong>💪 Prise de masse :</strong> Apport élevé en protéines et en calories, 5 à 6 repas par jour.</p>
                    <?php // plan pour entretien et bien-être ?>
                    <p><strong>🧘 Entretien &amp; Bien-être :</strong> Équilibre entre macronutriments, beaucoup de fibres, hydratation.</p>
                </div>
            </div>
        </div>

        <?php // section Aliments à favoriser / à éviter ?>
        <div class="col-md-6">
            <div class="card shadow h-100">
                <?php // en-tête de carte pour aliments à privilégier et limiter ?>
                <div class="card-header bg-warning fw-semibold">
                    Aliments à favoriser / à éviter
                </div>
                <div class="card-body">
                    <?php // liste des aliments à favoriser ?>
                    <p><strong>✅ À favoriser :</strong></p>
                    <ul>
                        <li>Légumes verts, fruits, céréales complètes</li>
                        <li>Viandes maigres, poissons, œufs</li>
                        <li>Fruits secs, graines, huiles végétales</li>
                    </ul>
                    <?php // liste des aliments à limiter ?>
                    <p><strong>❌ À limiter :</strong></p>
                    <ul>
                        <li>Sodas, fritures, pâtisseries</li>
                        <li>Plats préparés et trop salés</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <?php // bouton pour revenir à la page des services ?>
    <div class="text-center mt-5">
        <a href="services_salle.php" class="btn btn-outline-secondary">← Retour</a>
    </div>
</div>

<?php
// on inclut le footer pour finir la page
include 'footer.php';
?>```
