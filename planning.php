<?php
// démarre la session pour récupérer les infos utilisateur
session_start();
// inclut la connexion à la base de données
require_once 'includes/db.php';

// on récupère le nom du coach passé en paramètre GET
$coach = $_GET['coach'] ?? '';
// si aucun coach n'est précisé, renvoyer à la page browse
if (!$coach) {
    header("Location: browse.php");
    exit;
}

// prépare et exécute la requête pour récupérer toutes les disponibilités du coach
$dispos = $pdo->prepare("SELECT date_disp, heure_disp FROM disponibilities WHERE nom_coach = ?");
$dispos->execute([$coach]);
$allDispos = $dispos->fetchAll(PDO::FETCH_ASSOC);

// prépare et exécute la requête pour récupérer tous les RDV déjà pris pour ce coach
$rdv = $pdo->prepare("SELECT date_rdv, heure_rdv FROM rdv WHERE nom_coach = ?");
$rdv->execute([$coach]);
$reserved = $rdv->fetchAll(PDO::FETCH_ASSOC);

// on définit les jours où le coach est disponible
$jours = ['lundi', 'mercredi', 'vendredi'];
// on définit les créneaux AM et PM à l'aide d'un tableau
$creneaux = [
    'AM' => ['09:00:00','09:20:00','09:40:00','10:00:00','10:20:00','10:40:00','11:00:00','11:20:00','11:40:00','12:00:00'],
    'PM' => ['14:00:00','14:20:00','14:40:00','15:00:00','15:20:00','15:40:00','16:00:00','16:20:00','16:40:00','17:00:00','17:20:00','17:40:00','18:00:00']
];

// on initialise le tableau $etat pour chaque jour et chaque période à 'indispo'
$etat = [];
foreach ($jours as $jour) {
    foreach (['AM','PM'] as $periode) {
        foreach ($creneaux[$periode] as $h) {
            $etat[$jour][$periode][$h] = 'indispo';
        }
    }
}

// on parcourt toutes les dispos pour marquer les créneaux disponibles
foreach ($allDispos as $slot) {
    // on récupère le jour en anglais depuis la date, puis on traduit en français
    $jourNom = strtolower(date('l', strtotime($slot['date_disp'])));
    $jourTraduit = [
        'monday' => 'lundi',
        'wednesday' => 'mercredi',
        'friday' => 'vendredi'
    ][$jourNom] ?? null;

    // si le jour traduit existe, on marque ce créneau en AM et PM comme 'dispo'
    if ($jourTraduit && isset($etat[$jourTraduit]['AM'][$slot['heure_disp']]) || isset($etat[$jourTraduit]['PM'][$slot['heure_disp']])) {
        $etat[$jourTraduit]['AM'][$slot['heure_disp']] = 'dispo';
        $etat[$jourTraduit]['PM'][$slot['heure_disp']] = 'dispo';
    }
}

// on parcourt tous les RDV pour marquer les créneaux réservés
foreach ($reserved as $res) {
    // même mécanique : récupération du jour en anglais puis traduction en français
    $jourNom = strtolower(date('l', strtotime($res['date_rdv'])));
    $jourTraduit = [
        'monday' => 'lundi',
        'wednesday' => 'mercredi',
        'friday' => 'vendredi'
    ][$jourNom] ?? null;

    // si le jour traduit existe, on marque ce créneau en AM et PM comme 'res'
    if ($jourTraduit) {
        if (isset($etat[$jourTraduit]['AM'][$res['heure_rdv']])) {
            $etat[$jourTraduit]['AM'][$res['heure_rdv']] = 'res';
        }
        if (isset($etat[$jourTraduit]['PM'][$res['heure_rdv']])) {
            $etat[$jourTraduit]['PM'][$res['heure_rdv']] = 'res';
        }
    }
}
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <!-- affiche le titre du planning avec le nom du coach -->
    <h3 class="mb-4 text-center">Planning de <strong><?= htmlspecialchars($coach) ?></strong></h3>

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>Heure</th>
                <!-- on affiche une colonne AM et PM pour chaque jour -->
                <?php foreach ($jours as $j): ?>
                    <th><?= ucfirst($j) ?> AM</th>
                    <th><?= ucfirst($j) ?> PM</th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            // on fusionne tous les créneaux AM et PM pour trier et afficher ligne par ligne
            $allHeures = array_unique(array_merge($creneaux['AM'], $creneaux['PM']));
            sort($allHeures);
            foreach ($allHeures as $h):
            ?>
                <tr>
                    <!-- on affiche l'heure sans les secondes -->
                    <td><?= substr($h, 0, 5) ?></td>
                    <?php foreach ($jours as $j): ?>
                        <?php
                        // on récupère l'état AM et PM pour ce jour et cette heure
                        $amClass = $etat[$j]['AM'][$h] ?? 'indispo';
                        $pmClass = $etat[$j]['PM'][$h] ?? 'indispo';
                        ?>
                        <!-- on applique une classe selon l'état pour styliser la case -->
                        <td class="<?= $amClass ?>"><?= ($amClass !== 'indispo') ? substr($h, 0, 5) : '' ?></td>
                        <td class="<?= $pmClass ?>"><?= ($pmClass !== 'indispo') ? substr($h, 0, 5) : '' ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
    /* style pour les cases disponibles : fond bleu clair et curseur pointeur */
    td.dispo { background-color: #b2d8f7; cursor: pointer; }
    /* style pour les cases réservées : fond bleu foncé et texte en blanc */
    td.res { background-color: #007bff; color: white; }
    /* style pour les cases indisponibles : fond noir et texte en blanc */
    td.indispo { background-color: #000; color: white; }
</style>

<?php include 'footer.php'; ?>
