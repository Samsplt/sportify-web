<?php
// on vérifie si une session n'est pas encore démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // on lance la session pour garder les infos de l'utilisateur
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Sportify</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- on intègre le CSS de Bootstrap depuis un CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- on charge notre fichier CSS personnalisé -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">

<!-- début de la barre de navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm border-bottom">
  <div class="container">
    <!-- logo ou nom du site qui renvoie à la page d'accueil -->
    <a class="navbar-brand fw-bold text-primary" href="index.php">SPORTIFY</a>

    <!-- bouton pour afficher le menu en version mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- liens de navigation qui se cachent sur mobile -->
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav ms-auto">

        <!-- lien vers la page d'accueil -->
        <li class="nav-item">
          <a class="nav-link" href="index.php">Accueil</a>
        </li>

        <!-- menu déroulant "Tout Parcourir" -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Tout Parcourir
          </a>
          <ul class="dropdown-menu">
            <!-- lien vers les activités sportives -->
            <li><a class="dropdown-item" href="browse.php?cat=activites">Activités sportives</a></li>
            <!-- lien vers les sports de compétition -->
            <li><a class="dropdown-item" href="browse.php?cat=competition">Sports de compétition</a></li>
            <!-- lien vers la salle de sport Omnes -->
            <li><a class="dropdown-item" href="browse.php?cat=salle">Salle de sport Omnes</a></li>
          </ul>
        </li>

        <!-- lien vers la page de recherche -->
        <li class="nav-item">
          <a class="nav-link" href="search.php">Recherche</a>
        </li>

        <!-- lien vers la page de rendez-vous -->
        <li class="nav-item">
          <a class="nav-link" href="rdv.php">Rendez-vous</a>
        </li>

        <!-- section pour la gestion du compte : on vérifie si l'utilisateur est connecté -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- si connecté, afficher son nom et un menu de compte -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown">
                    <?= htmlspecialchars($_SESSION['user_name']) // affiche le nom de l'utilisateur en toute sécurité ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <!-- lien vers la page "Mon compte" -->
                    <li><a class="dropdown-item" href="account.php">Mon compte</a></li>
                    <!-- lien pour se déconnecter -->
                    <li><a class="dropdown-item text-danger" href="logout.php">Se déconnecter</a></li>
                </ul>
            </li>
        <?php else: ?>
            <!-- si pas connecté, proposer de se connecter ou de s'inscrire -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="guestDropdown" role="button" data-bs-toggle="dropdown">
                    Votre Compte
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <!-- lien vers la page de connexion -->
                    <li><a class="dropdown-item" href="login.php">Connexion</a></li>
                    <!-- lien vers la page d'inscription -->
                    <li><a class="dropdown-item" href="register.php">Inscription</a></li>
                </ul>
            </li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>
