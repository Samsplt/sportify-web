<?php
// démarrer la session, inclure la DB et le header
session_start();
require_once 'includes/db.php';
include 'header.php';

// récupérer le nom du coach passé en GET
$coach = $_GET['coach'] ?? '';
if (!$coach) {
    // si pas de coach, renvoyer à la page browse
    header("Location: browse.php");
    exit;
}

// récupérer tous les créneaux dispos du coach
$dispos = $pdo->prepare("SELECT date_disp, heure_disp FROM disponibilities WHERE nom_coach = ?");
$dispos->execute([$coach]);
$allDispos = $dispos->fetchAll(PDO::FETCH_ASSOC);

// récupérer tous les RDV déjà pris pour ce coach
$rdv = $pdo->prepare("SELECT date_rdv, heure_rdv FROM rdv WHERE nom_coach = ?");
$rdv->execute([$coach]);
$reserved = $rdv->fetchAll(PDO::FETCH_ASSOC);

// créer les créneaux horaires (de 8h à 18h)
$jours = ['lundi', 'mercredi', 'vendredi'];
$creneaux = [];
for ($h = 8; $h <= 18; $h++) {
    // formater en HH:00:00
    $creneaux[] = sprintf('%02d:00:00', $h);
}

// initialiser l’état de chaque case à 'indispo'
$etat = [];
foreach ($jours as $jour) {
    foreach ($creneaux as $heure) {
        $etat[$jour][$heure] = 'indispo';
    }
}

// parcourir toutes les dispos pour passer à 'dispo'
foreach ($allDispos as $slot) {
    $jour = strtolower(date('l', strtotime($slot['date_disp'])));
    $jourTraduit = ['monday'=>'lundi','wednesday'=>'mercredi','friday'=>'vendredi'][$jour] ?? null;
    if ($jourTraduit && isset($etat[$jourTraduit][$slot['heure_disp']])) {
        $etat[$jourTraduit][$slot['heure_disp']] = 'dispo';
    }
}

// parcourir tous les RDV pour passer à 'res' (réservé)
foreach ($reserved as $res) {
    $jour = strtolower(date('l', strtotime($res['date_rdv'])));
    $jourTraduit = ['monday'=>'lundi','wednesday'=>'mercredi','friday'=>'vendredi'][$jour] ?? null;
    if ($jourTraduit && isset($etat[$jourTraduit][$res['heure_rdv']])) {
        $etat[$jourTraduit][$res['heure_rdv']] = 'res';
    }
}
?>

<div class="container mt-5">
    <!-- titre du planning -->
    <h3 class="mb-4 text-center">Planning de <strong><?= htmlspecialchars($coach) ?></strong></h3>

    <!-- afficher la photo du coach -->
    <div class="text-center mb-4">
        <img src="images_photos/coachs/<?= urlencode($coach) ?>.jpg" 
             alt="<?= $coach ?>" 
             class="img-fluid rounded" 
             style="max-height: 200px;">
    </div>

    <!-- tableau du planning -->
    <table class="table table-bordered text-center">
        <thead class="table-light">
            <tr>
                <th>Heure</th>
                <?php foreach ($jours as $j): ?>
                    <th><?= ucfirst($j) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($creneaux as $heure): ?>
                <tr>
                    <!-- afficher l'heure sans les secondes -->
                    <th><?= substr($heure, 0, 5) ?></th>
                    <?php foreach ($jours as $jour): ?>
                        <?php
                        // déterminer l’état pour ce jour et cette heure
                        $state = $etat[$jour][$heure];
                        // couleur selon dispo, réservé ou hors service
                        $color = ($state === 'dispo') ? '#ffffff' : (($state === 'res') ? '#007bff' : '#000');
                        // si dispo et utilisateur connecté, rendre cliquable
                        $click = ($state === 'dispo' && isset($_SESSION['user_id'])) ?
                            "onclick=\"reserver('{$coach}', '{$jour}', '{$heure}', this)\"" : '';
                        ?>
                        <td style="background-color: <?= $color ?>; cursor: <?= $click ? 'pointer' : 'default' ?>;" <?= $click ?>></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- légende des couleurs -->
    <div class="mt-3 text-muted small">
        ⚪ Disponible | 🟦 Réservé | ⚫ Indisponible
    </div>
</div>

<script>
// fonction pour envoyer la demande de réservation en AJAX
function reserver(coach, jour, heure, cell) {
    if (confirm(`Confirmer le RDV avec ${coach} le ${jour} à ${heure} ?`)) {
        fetch('reserver_ajax.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `coach=${encodeURIComponent(coach)}&jour=${jour}&heure=${heure}`
        })
        .then(res => res.text())
        .then(resp => {
            if (resp === 'success') {
                // si tout passe, on colore en bleu et on désactive le clic
                cell.style.backgroundColor = '#007bff';
                cell.onclick = null;
            } else {
                alert("Erreur: " + resp);
            }
        });
    }
}
</script>

<style>
    /* transition pour un effet plus smooth quand on change la couleur */
    td { transition: background-color 0.2s; }
</style>

<?php include 'footer.php'; ?>
