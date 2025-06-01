<?php
// on inclut le header pour avoir la nav et le style
include 'header.php';
?>

<div class="container my-5">
    <!-- titre de bienvenue pour la salle -->
    <h2 class="text-center mb-4 text-primary">Bienvenue chez Basic Fit Paris 15</h2>
    
    <!-- carte de présentation générale -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <!-- titre de la section Présentation -->
            <h4 class="card-title text-success">🏋️‍♂️ Présentation</h4>
            <p>
                <!-- texte de présentation avec le nom de la salle en gras -->
                Bienvenue chez <strong>Basic Fit Paris 15</strong>, votre espace de remise en forme, bien-être et performance au cœur du 15e arrondissement. 
                Nous vous accompagnons dès vos premiers pas dans votre transformation physique et mentale.
            </p>
        </div>
    </div>

    <!-- carte pour afficher l’accès à la salle -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <!-- titre de la section Accès à la salle -->
            <h4 class="card-title text-success">📍 Accès à la salle</h4>
            <ul>
                <!-- adresse en list-item -->
                <li><strong>Adresse :</strong> 133 Rue de Javel, 75015 Paris</li>
                <!-- horaires d’ouverture en list-item -->
                <li><strong>Horaires :</strong> Lundi à Jeudi : 7h - 23h, Mercredi : 8h - 22h, Vendredi : 6h - 00h</li>
                <!-- consigne pour accéder à la salle -->
                <li><strong>Accès :</strong> Présentez votre carte d’adhérent à l’entrée.</li>
            </ul>
        </div>
    </div>

    <!-- carte pour lister les services inclus -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <!-- titre de la section Services Inclus -->
            <h4 class="card-title text-success">💡 Services Inclus</h4>
            <ul>
                <!-- accès illimité aux équipements -->
                <li>Accès illimité à toutes les machines et équipements</li>
                <!-- coaching individuel selon abonnement -->
                <li>Coaching individuel (selon abonnement)</li>
                <!-- accès aux infrastructures d’hygiène -->
                <li>Accès aux douches, vestiaires et casiers sécurisés</li>
                <!-- suivi nutritionnel sur demande -->
                <li>Suivi nutritionnel personnalisé (sur demande)</li>
            </ul>
        </div>
    </div>

    <!-- carte pour indiquer les règles essentielles -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <!-- titre de la section Règles Essentielles -->
            <h4 class="card-title text-success">📌 Règles Essentielles</h4>
            <ul>
                <!-- obligation d’apporter serviette et chaussures propres -->
                <li>Apportez une serviette et des chaussures propres obligatoires</li>
                <!-- consigne de nettoyage des machines -->
                <li>Désinfectez les machines après chaque utilisation</li>
                <!-- respect des autres adhérents et du matériel -->
                <li>Respectez les autres adhérents et le matériel</li>
                <!-- obligation d’utiliser un casque pour la musique -->
                <li>Écouteurs ou casque obligatoire pour écouter de la musique</li>
            </ul>
        </div>
    </div>

    <!-- carte pour présenter les tarifs et abonnements -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <!-- titre de la section Tarifs & Abonnements -->
            <h4 class="card-title text-success">💳 Tarifs & Abonnements</h4>
            <ul>
                <!-- tarif mensuel sans engagement -->
                <li><strong>Mensuel sans engagement :</strong> 29,99€</li>
                <!-- tarif annuel avec offre -->
                <li><strong>Abonnement annuel :</strong> 299€ (2 mois offerts)</li>
                <!-- réduction Étudiant -->
                <li><strong>Offre Étudiant :</strong> -20% sur tous les forfaits</li>
                <!-- tarif pack duo -->
                <li><strong>Pack Duo :</strong> 49,99€/mois pour deux personnes</li>
            </ul>
        </div>
    </div>

    <!-- bouton pour revenir à la page des services -->
    <div class="text-center">
        <a href="services_salle.php" class="btn btn-outline-secondary mt-4">← Retour aux services</a>
    </div>
</div>

<?php
// on inclut le footer pour terminer la page
include 'footer.php';
?>```
