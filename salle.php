<?php
// on inclut le header pour afficher la barre de navigation et le style
include 'header.php';
?>

<div class="container mt-5">
    <!-- titre principal de la page -->
    <h2 class="mb-4">Salle de sport Omnes</h2>

    <!-- section d’information sur la salle -->
    <div class="row align-items-center p-4 bg-light rounded shadow">
        <div class="col-md-5 text-center">
            <!-- image illustrant la salle -->
            <img src="images_photos/salle_omnes.jpg" alt="Salle Omnes" class="img-fluid rounded">
        </div>
        <div class="col-md-7">
            <!-- nom de la salle -->
            <h4 class="mb-3"><strong>Salle de sport Omnes</strong></h4>
            <!-- numéro ou identifiant de la salle -->
            <p><strong>Salle :</strong> G-001</p>
            <!-- numéro de téléphone pour contacter la salle -->
            <p><strong>Téléphone :</strong> +33 01 22 33 44 55</p>
            <!-- adresse email pour contacter la salle -->
            <p><strong>Email :</strong> salle.sport@omnessports.fr</p>

            <!-- bouton pour accéder à la page des services de la salle -->
            <a href="services.php" class="btn btn-warning fw-semibold px-4 mt-3">
                Nos services
            </a>
        </div>
    </div>

    <!-- description textuelle des fonctionnalités et services -->
    <div class="mt-5">
        <p>
            <!-- explication du bouton 'Nos services' -->
            En cliquant sur le bouton <strong>« Nos services »</strong>, on va trouver des services fournis par la salle de sport,
            tels que <strong>« Personnels de la salle de sport »</strong>, <strong>« Horaire de la gym »</strong>,
            <strong>« Règles sur l’utilisation des machines »</strong>, <strong>« Nouveaux clients »</strong>,
            et <strong>« Alimentation et nutrition »</strong>.
        </p>
        <p>
            <!-- détail sur ce qu’on trouve dans la catégorie 'Règles sur l’utilisation des machines' -->
            En sélectionnant une catégorie, par exemple <strong>« Règles sur l’utilisation des machines »</strong>,
            on va trouver des informations liées à l’utilisation des dispositifs sportifs, par exemple les poids, haltères,
            barbillons, appareils cardio, etc.
        </p>
        <p>
            <!-- explication de la fonctionnalité de réservation d’un créneau -->
            Ensuite, il y a un calendrier des créneaux disponibles pour visiter la salle de sport. En cliquant sur le créneau disponible,
            on est assuré de notre RDV avec la salle de sport Omnes.
        </p>
    </div>
</div>

<?php
// on inclut le footer pour terminer la page
include 'footer.php';
?>
