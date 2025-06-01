<?php
// on vérifie si l'utilisateur est connecté, sinon on retourne à la page de connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// on inclut le header pour afficher la barre de navigation
include 'header.php';

// on récupère le rôle et le nom depuis la session, ou on met des valeurs par défaut
$role = $_SESSION['user_role'] ?? 'client';
$nom  = $_SESSION['user_nom'] ?? 'Utilisateur';

// on ouvre un conteneur Bootstrap pour la page
echo "<div class='container mt-5'>";
// on affiche un titre de bienvenue avec le nom de l'utilisateur
echo "<h2>Bienvenue, $nom</h2>";

// selon le rôle de l'utilisateur, on affiche un contenu différent
switch ($role) {
    case 'admin':
        // si c'est un administrateur, on indique son rôle et on propose le lien vers le panneau d'admin
        echo "<p>Vous êtes connecté en tant qu'<strong>Administrateur</strong>.</p>";
        echo "<a href='admin_panel.php' class='btn btn-danger'>Gérer le site</a>";
        break;

    case 'coach':
        // si c'est un coach, on affiche le rôle Coach/Personnel et on met le lien vers ses rendez-vous
        echo "<p>Vous êtes connecté en tant que <strong>Coach / Personnel</strong>.</p>";
        echo "<a href='coach_dashboard.php' class='btn btn-success'>Voir vos RDVs</a>";
        break;

    default:
        // sinon c'est un client, on affiche le rôle Client et on met le lien vers ses rendez-vous
        echo "<p>Vous êtes connecté en tant que <strong>Client</strong>.</p>";
        echo "<a href='rdv.php' class='btn btn-primary'>Voir mes rendez-vous</a>";
        break;
}

// on ferme le conteneur
echo "</div>";

// on inclut le footer pour terminer la page
include 'footer.php';
?>
