<?php
// j’inclus le header pour la barre de nav et le style
include 'header.php';
?>

<div class="container mt-5">
    <?php // titre de la page Sports de compétition ?>
    <h2 class="text-center mb-4">Sports de compétition</h2>

    <div class="row text-center">
        <?php // première carte : Football ?>
        <div class="col-md-4 mb-4">
            <div class="card p-3 shadow">
                <?php // zone réservée à l'image, pour faire joli ?>
                <div class="mb-2" style="height:200px;background:#ccc;display:flex;align-items:center;justify-content:center;">
                    <span>Image Football</span>
                </div>
                <?php // bouton qui pointe vers la page Football (ajuster le lien plus tard) ?>
                <a href="#" class="btn btn-outline-primary mt-2">Football</a>
            </div>
        </div>

        <?php // deuxième carte : Rugby ?>
        <div class="col-md-4 mb-4">
            <div class="card p-3 shadow">
                <?php // espace pour afficher une image de Rugby ?>
                <div class="mb-2" style="height:200px;background:#ccc;display:flex;align-items:center;justify-content:center;">
                    <span>Image Rugby</span>
                </div>
                <?php // lien vers la section Rugby ?>
                <a href="#" class="btn btn-outline-primary mt-2">Rugby</a>
            </div>
        </div>

        <?php // troisième carte : Tennis ?>
        <div class="col-md-4 mb-4">
            <div class="card p-3 shadow">
                <?php // emplacement pour l'image de Tennis ?>
                <div class="mb-2" style="height:200px;background:#ccc;display:flex;align-items:center;justify-content:center;">
                    <span>Image Tennis</span>
                </div>
                <?php // bouton Tennis ?>
                <a href="#" class="btn btn-outline-primary mt-2">Tennis</a>
            </div>
        </div>

        <?php // quatrième carte : Natation ?>
        <div class="col-md-4 mb-4">
            <div class="card p-3 shadow">
                <?php // ici on mettra l'image de Natation ?>
                <div class="mb-2" style="height:200px;background:#ccc;display:flex;align-items:center;justify-content:center;">
                    <span>Image Natation</span>
                </div>
                <?php // lien vers Natation ?>
                <a href="#" class="btn btn-outline-primary mt-2">Natation</a>
            </div>
        </div>

        <?php // cinquième carte : Athlétisme ?>
        <div class="col-md-4 mb-4">
            <div class="card p-3 shadow">
                <?php // placeholder pour l'image d'Athlétisme ?>
                <div class="mb-2" style="height:200px;background:#ccc;display:flex;align-items:center;justify-content:center;">
                    <span>Image Athlétisme</span>
                </div>
                <?php // bouton Athlétisme ?>
                <a href="#" class="btn btn-outline-primary mt-2">Athlétisme</a>
            </div>
        </div>

        <?php // sixième carte : Haltérophilie ?>
        <div class="col-md-4 mb-4">
            <div class="card p-3 shadow">
                <?php // zone image pour Haltérophilie ?>
                <div class="mb-2" style="height:200px;background:#ccc;display:flex;align-items:center;justify-content:center;">
                    <span>Image Haltérophilie</span>
                </div>
                <?php // bouton Haltérophilie ?>
                <a href="#" class="btn btn-outline-primary mt-2">Haltérophilie</a>
            </div>
        </div>
    </div>
</div>

<?php
// j’inclus le footer pour fermer le HTML et ajouter le pied de page
include 'footer.php';
?>
