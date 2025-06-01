<?php
// démarre la session pour garder en mémoire l'utilisateur
session_start();
// inclut la connexion à la base de données
require_once 'includes/db.php';
// inclut le header pour afficher la barre de navigation
include 'header.php';

// 🧠 Identifier le coach : on récupère le paramètre 'coach' depuis l'URL
$coach = $_GET['coach'] ?? '';
// on remplace les espaces par des underscores pour correspondre à notre base
$coach = str_replace(' ', '_', $coach);

// si aucun coach n'est précisé, on renvoie à la page browse.php
if (!$coach) {
    header("Location: browse.php");
    exit;
}

// 📦 Récupération des infos du coach dans la table 'disponibilities'
$stmt = $pdo->prepare("
    SELECT * FROM disponibilities 
    WHERE REPLACE(nom_coach, ' ', '_') = ? 
    LIMIT 1
");
$stmt->execute([$coach]);
$data = $stmt->fetch();

// si aucun enregistrement trouvé, on affiche un message d'erreur et on arrête
if (!$data) {
    echo "<h3 class='text-center mt-5'>Coach introuvable</h3>";
    include 'footer.php';
    exit;
}

// on extrait les informations du coach ou on met des valeurs par défaut
$sport = $data['sport'];
$photo = $data['photo'] ?? 'default.jpg';
$cv = $data['cv_filename'] ?? null;
// si l'email n'est pas renseigné, on le génère à partir du nom du coach
$email = $data['email'] ?? strtolower(str_replace('_', '.', $coach)) . '@omnessports.fr';
$tel = $data['telephone'] ?? 'Non renseigné';
$salle = $data['salle'] ?? 'Non attribuée';
$desc = $data['description'] ?? '';

// 🔁 Récupération des créneaux disponibles
$dispoStmt = $pdo->prepare("
    SELECT date_disp, heure_disp 
    FROM disponibilities 
    WHERE REPLACE(nom_coach, ' ', '_') = ?
");
$dispoStmt->execute([$coach]);
$allDispos = $dispoStmt->fetchAll();

// 🔁 Récupération des créneaux déjà réservés
$rdvStmt = $pdo->prepare("
    SELECT date_rdv, heure_rdv 
    FROM rdv 
    WHERE REPLACE(nom_coach, ' ', '_') = ?
");
$rdvStmt->execute([$coach]);
$reserved = $rdvStmt->fetchAll();

// 📅 Initialisation du planning : on ne prend que certains jours de la semaine
$jours = ['lundi', 'mercredi', 'vendredi'];
$creneaux = [];
// si le sport nécessite 2h par créneau (football, tennis, natation), on saute 2h
$special2h = in_array(strtolower($sport), ['football', 'tennis', 'natation']);
// on construit les créneaux horaires de 8h à 18h (ou en sautant 2h selon le sport)
for ($h = 8; $h <= 18 - ($special2h ? 1 : 0); $h += $special2h ? 2 : 1) {
    // on formate l'heure en HH:00:00
    $creneaux[] = sprintf('%02d:00:00', $h);
}

// on initialise un tableau pour l'état de chaque case du planning
$etat = [];
foreach ($jours as $j) {
    foreach ($creneaux as $h) {
        // par défaut, on suppose indisponible
        $etat[$j][$h] = 'indispo';
    }
}

// on parcourt toutes les disponibilités pour passer l'état à 'dispo'
foreach ($allDispos as $slot) {
    // on détermine le jour en anglais puis on traduit en français
    $jour = strtolower(date('l', strtotime($slot['date_disp'])));
    $trad = ['monday'=>'lundi','wednesday'=>'mercredi','friday'=>'vendredi'][$jour] ?? null;
    if ($trad && isset($etat[$trad][$slot['heure_disp']])) {
        $etat[$trad][$slot['heure_disp']] = 'dispo';
    }
}

// on parcourt toutes les réservations pour passer l'état à 'res' (réservé)
foreach ($reserved as $res) {
    $jour = strtolower(date('l', strtotime($res['date_rdv'])));
    $trad = ['monday'=>'lundi','wednesday'=>'mercredi','friday'=>'vendredi'][$jour] ?? null;
    if ($trad && isset($etat[$trad][$res['heure_rdv']])) {
        $etat[$trad][$res['heure_rdv']] = 'res';
    }
}
?>

<div class="container mt-5">
    <!-- titre du planning avec le nom du coach -->
    <h3 class="mb-4 text-center">Planning de <strong><?= htmlspecialchars(str_replace('_', ' ', $coach)) ?></strong></h3>

    <!-- 🧾 Infos Coach -->
    <div class="text-center mb-4">
        <!-- photo du coach -->
        <img src="images_photos/coachs/<?= htmlspecialchars($photo) ?>" 
             alt="<?= $coach ?>" 
             class="img-fluid rounded" 
             style="max-height: 200px;">
        <div class="mt-3 d-flex justify-content-center gap-3 flex-wrap">
            <!-- bouton pour envoyer un mail -->
            <a href="mailto:<?= htmlspecialchars($email) ?>" class="btn btn-primary">
                <i class="bi bi-envelope"></i> Contacter
            </a>
            <?php if ($cv): ?>
                <!-- bouton pour voir le CV si présent -->
                <a href="cv_view.php?file=<?= urlencode($cv) ?>" 
                   target="_blank" 
                   class="btn btn-outline-secondary">
                    <i class="bi bi-file-earmark-person"></i> Voir le CV
                </a>
            <?php endif; ?>
        </div>
        <div class="mt-3 text-start mx-auto" style="max-width: 600px;">
            <!-- affichage des informations de contact et salle -->
            <p><strong>Salle :</strong> <?= htmlspecialchars($salle) ?></p>
            <p><strong>Téléphone :</strong> <?= htmlspecialchars($tel) ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($email) ?></p>
            <?php if ($desc): ?>
                <!-- description du coach si disponible -->
                <p><strong>À propos :</strong><br><?= nl2br(htmlspecialchars($desc)) ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- 🗓️ Planning -->
    <table class="table table-bordered text-center">
        <thead class="table-light">
            <tr>
                <th>Heure</th>
                <?php foreach ($jours as $j): ?>
                    <!-- on affiche chaque jour en en-tête de colonne -->
                    <th><?= ucfirst($j) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($creneaux as $heure): ?>
                <tr>
                    <!-- colonne de l'heure sans les secondes -->
                    <th><?= substr($heure, 0, 5) ?></th>
                    <?php foreach ($jours as $jour): ?>
                        <?php
                        // on récupère l'état pour ce jour et cette heure
                        $state = $etat[$jour][$heure];
                        // on choisit la couleur selon l'état : blanc=dispo, bleu=réservé, noir=indispo
                        $color = ($state === 'dispo') ? '#ffffff' : (($state === 'res') ? '#007bff' : '#000');
                        // si dispo et utilisateur connecté, on rend la case cliquable
                        $click = ($state === 'dispo' && isset($_SESSION['user_id'])) ?
                            "onclick=\"reserver('{$coach}', '{$jour}', '{$heure}', this)\"" : '';
                        ?>
                        <td 
                            style="background-color: <?= $color ?>; cursor: <?= $click ? 'pointer' : 'default' ?>;" 
                            <?= $click ?>>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- légende des couleurs -->
    <div class="text-center text-muted mt-3 small">
        ⚪ Disponible | 🟦 Réservé | ⚫ Indisponible
    </div>
</div>

<script>
// fonction JavaScript pour réserver un créneau avec AJAX
function reserver(coach, jour, heure, cell) {
    // on demande confirmation à l'utilisateur
    if (confirm(`Confirmer le RDV avec ${coach} le ${jour} à ${heure} ?`)) {
        fetch('reserver_ajax.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            // on envoie le coach, jour et heure
            body: `coach=${encodeURIComponent(coach)}&jour=${jour}&heure=${heure}`
        })
        .then(res => res.text())
        .then(resp => {
            if (resp === 'success') {
                // si tout se passe bien, on colore la case en bleu et on désactive le clic
                cell.style.backgroundColor = '#007bff';
                cell.onclick = null;
            } else {
                // sinon on affiche une alerte avec le message d'erreur
                alert("Erreur: " + resp);
            }
        });
    }
}
</script>

<?php
// inclut le footer pour afficher le bas de page
include 'footer.php';
?>```
