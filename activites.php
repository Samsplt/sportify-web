<?php
// on inclut le header pour la nav
include 'header.php';
?>

<div class="container mt-5">
    <!-- titre principal de la page -->
    <h2 class="text-center mb-4">Activités sportives</h2>

    <div class="row text-center">
        <!-- carte pour Musculation -->
        <div class="col-md-4 mb-4">
            <div class="card p-3 shadow">
                <!-- zone réservée pour l’image Musculation -->
                <div class="mb-2" style="height:200px;background:#ccc;display:flex;align-items:center;justify-content:center;">
                    <span>Image Muscu</span>
                </div>
                <!-- bouton vers la section Musculation -->
                <a href="#" class="btn btn-outline-primary mt-2">Musculation</a>
            </div>
        </div>

        <!-- carte pour Fitness -->
        <div class="col-md-4 mb-4">
            <div class="card p-3 shadow">
                <!-- zone pour l’image Fitness -->
                <div class="mb-2" style="height:200px;background:#ccc;display:flex;align-items:center;justify-content:center;">
                    <span>Image Fitness</span>
                </div>
                <!-- bouton vers la section Fitness -->
                <a href="#" class="btn btn-outline-primary mt-2">Fitness</a>
            </div>
        </div>

        <!-- carte pour Biking -->
        <div class="col-md-4 mb-4">
            <div class="card p-3 shadow">
                <!-- zone pour l’image Biking -->
                <div class="mb-2" style="height:200px;background:#ccc;display:flex;align-items:center;justify-content:center;">
                    <span>Image Biking</span>
                </div>
                <!-- bouton vers la section Biking -->
                <a href="#" class="btn btn-outline-primary mt-2">Biking</a>
            </div>
        </div>

        <!-- carte pour Cardio-training -->
        <div class="col-md-4 mb-4">
            <div class="card p-3 shadow">
                <!-- zone pour l’image Cardio-training -->
                <div class="mb-2" style="height:200px;background:#ccc;display:flex;align-items:center;justify-content:center;">
                    <span>Image Cardio</span>
                </div>
                <!-- bouton vers la section Cardio-training -->
                <a href="#" class="btn btn-outline-primary mt-2">Cardio-training</a>
            </div>
        </div>

        <!-- carte pour Cours Collectifs -->
        <div class="col-md-4 mb-4">
            <div class="card p-3 shadow">
                <!-- zone pour l’image Cours Collectifs -->
                <div class="mb-2" style="height:200px;background:#ccc;display:flex;align-items:center;justify-content:center;">
                    <span>Image Cours Collectifs</span>
                </div>
                <!-- bouton vers la section Cours Collectifs -->
                <a href="#" class="btn btn-outline-primary mt-2">Cours Collectifs</a>
            </div>
        </div>
    </div>
</div>

<?php
// on inclut le footer pour fermer la page
include 'footer.php';
?>
