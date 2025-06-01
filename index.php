<?php
// on inclut le header pour avoir la barre de nav
include 'header.php';
?>

<div class="container mt-5">
  <?php // section de bienvenue avec titre et description ?>
  <div class="text-center mb-5">
    <h1 class="mb-3">Bienvenue chez <span class="text-primary">Sportify</span> </h1>
    <p class="lead">Votre plateforme de référence pour la consultation sportive en ligne. Réservez des créneaux, suivez vos coachs préférés, découvrez nos services en salle, et plus encore !</p>
  </div>

  <?php // carrousel pour l’évènement de la semaine ?>
  <h2 class="text-center mb-4">Évènement de la semaine</h2>
  <div id="eventCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
    <div class="carousel-inner rounded shadow">

      <?php // première slide active avec image PSG vs Inter ?>
      <div class="carousel-item active">
        <img src="images_photos/evenements/psg.jpg" class="d-block w-100" alt="PSG vs Inter">
        <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
          <h5>🏆 PSG écrase l'Inter 5-0</h5>
          <p>Une victoire historique en finale européenne pour le club parisien au Stade de Munich.</p>
        </div>
      </div>

      <?php // deuxième slide avec image Roland-Garros 2025 ?>
      <div class="carousel-item">
        <img src="images_photos/evenements/nadal.jpg" class="d-block w-100" alt="Roland Garros">
        <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
          <h5>🎾 Roland-Garros 2025</h5>
          <p>La légende Rafael Nadal tire sa révérence dans un tournoi ou il aura laissé son empreinte.</p>
        </div>
      </div>

      <?php // troisième slide avec image Fitness Challenge ?>
      <div class="carousel-item">
        <img src="images_photos/evenements/fitnesschalenge.jpg" class="d-block w-100" alt="Fitness Challenge">
        <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
          <h5>💪 Fitness Challenge Sportify</h5>
          <p>Relevez le défi du mois : rameur, burpees et gainage intensif. Qui sera champion ?</p>
        </div>
      </div>

      <?php // quatrième slide avec image Jeux Interuniversitaires ?>
      <div class="carousel-item">
        <img src="images_photos/evenements/jeux.jpg" class="d-block w-100" alt="Jeux Interuniversitaires">
        <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
          <h5>🏅 Jeux Interuniversitaires</h5>
          <p>Sportify représentera Omnes Éducation lors de l’évènement annuel à Paris.</p>
        </div>
      </div>
    </div>

    <?php // boutons pour naviguer dans le carrousel ?>
    <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>

  <?php // section pour l’adresse et la carte Google Maps ?>
  <div class="row mt-5">
    <div class="col-md-6 mb-4">
      <h3>📍 Notre adresse</h3>
      <p><strong>Sportify</strong><br>13 rue Seixtus Michel, 75015 Paris<br>Téléphone : 01 23 45 67 89<br>Email : sportify@omnessport.fr</p>
    </div>
    <div class="col-md-6">
      <?php // iframe pour afficher la carte Google Maps ?>
      <iframe class="w-100 rounded" height="300"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.3373041220873!2d2.2892203156740164!3d48.850753379286175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e67020330f585b%3A0x405d643317a963c!2s10%20Rue%20du%20Sport%2C%2075000%20Paris!5e0!3m2!1sfr!2sfr!4v1717159999999"
        style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </div>
</div>

<?php
// on inclut le footer pour terminer la page
include 'footer.php';
