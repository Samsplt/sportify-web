<?php
// démarre la session pour gérer l'utilisateur
session_start();
// inclut le fichier de connexion à la base de données
require_once 'includes/db.php';
// affiche la barre de navigation et le header
include 'header.php';

// définit les horaires d'ouverture pour chaque jour en heures entières
$horaires = [
    'Monday' => ['start' => 7, 'end' => 23],
    'Tuesday' => ['start' => 7, 'end' => 23],
    'Wednesday' => ['start' => 8, 'end' => 22],
    'Thursday' => ['start' => 7, 'end' => 23],
    'Friday' => ['start' => 6, 'end' => 24],
];

// tableau pour traduire les jours de l'anglais au français
$jours = [
    'Monday'    => 'Lundi',
    'Tuesday'   => 'Mardi',
    'Wednesday' => 'Mercredi',
    'Thursday'  => 'Jeudi',
    'Friday'    => 'Vendredi'
];
?>

<div class="container mt-5">
    <!-- bouton pour revenir à la page des services -->
    <a href="services_salle.php" class="btn btn-outline-secondary mb-4">← Retour</a>
    <h2 class="mb-4 text-center">🗓️ Horaires de la Salle de Sport</h2>

    <?php if (!isset($_SESSION['user_id'])): ?>
        <!-- informe l'utilisateur qu'il doit se connecter pour pouvoir réserver -->
        <div class="alert alert-warning text-center">Veuillez vous connecter pour réserver un créneau.</div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>Heure</th>
                    <?php foreach ($jours as $en => $fr): ?>
                        <!-- affiche l'en-tête avec les jours en français -->
                        <th><?= $fr ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                // on parcourt toutes les heures de 6h à 23h
                for ($h = 6; $h <= 23; $h++) {
                    $heure = sprintf('%02d:00', $h);
                    echo "<tr><th>$heure</th>";

                    // pour chaque jour, on vérifie la disponibilité du créneau
                    foreach (array_keys($jours) as $jourEn) {
                        // calculer la date du prochain jourEn (Lundi, Mardi, etc.)
                        $now = new DateTime();
                        $jourDate = $now->modify("next $jourEn")->format('Y-m-d');

                        // récupère l'heure d'ouverture et de fermeture pour ce jour
                        $start = $horaires[$jourEn]['start'];
                        $end = $horaires[$jourEn]['end'];

                        // si l'heure est dans la plage d'ouverture
                        if ($h >= $start && $h < $end) {
                            // prépare la requête pour vérifier si le créneau est déjà réservé
                            $stmt = $pdo->prepare("SELECT * FROM rdv_salle WHERE date_rdv = ? AND heure_rdv = ?");
                            $stmt->execute([$jourDate, $heure]);
                            $isReserved = $stmt->rowCount() > 0;

                            if ($isReserved) {
                                // si réservé, on colore la case en bleu
                                echo "<td style='background-color: #007BFF;'>&nbsp;</td>";
                            } else {
                                if (isset($_SESSION['user_id'])) {
                                    // si libre et que l'utilisateur est connecté, la case est cliquable
                                    echo "<td style='background-color: white; cursor: pointer;' onclick=\"reserverSalle('{$jourDate}', '{$heure}', this)\"></td>";
                                } else {
                                    // si libre mais non connecté, la case reste blanche non cliquable
                                    echo "<td style='background-color: white;'>&nbsp;</td>";
                                }
                            }
                        } else {
                            // en dehors des horaires d'ouverture, la case est noire
                            echo "<td style='background-color: black;'>&nbsp;</td>";
                        }
                    }

                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- légende expliquant la couleur des cases -->
        <div class="text-center mt-2 small">
            ⚪ Disponible | 🟦 Réservé | ⚫ Indisponible
        </div>
    </div>
</div>

<script>
// fonction JavaScript pour envoyer la requête AJAX de réservation
function reserverSalle(date, heure, cell) {
    if (!confirm(`Confirmer le RDV pour la salle le ${date} à ${heure} ?`)) return;

    fetch('reserver_salle_ajax.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `date=${date}&heure=${heure}`
    })
    .then(res => res.text())
    .then(resp => {
        if (resp === 'success') {
            // si la réservation est bien prise, on colore la case en bleu et on désactive le clic
            cell.style.backgroundColor = '#007BFF';
            cell.onclick = null;
        } else if (resp === 'already_booked') {
            alert("Ce créneau est déjà réservé.");
        } else if (resp === 'not_logged_in') {
            alert("Veuillez vous connecter pour réserver.");
        } else {
            alert("Erreur : " + resp);
        }
    });
}
</script>

<?php
// inclut le footer pour terminer la page
include 'footer.php';
?>
