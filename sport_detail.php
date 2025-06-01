<?php
// démarrer la session pour récupérer l’utilisateur
session_start();
// inclure la connexion à la base de données
require_once 'includes/db.php';
// afficher le header (navbar, styles, etc.)
include 'header.php';

// récupérer le nom du coach passé en GET ou rediriger si absent
$coach = $_GET['coach'] ?? '';
if (!$coach) {
    header("Location: browse.php");
    exit;
}

// récupérer toutes les disponibilités du coach
$dispos = $pdo->prepare("SELECT date_disp, heure_disp FROM disponibilities WHERE nom_coach = ?");
$dispos->execute([$coach]);
$allDispos = $dispos->fetchAll(PDO::FETCH_ASSOC);

// récupérer tous les rendez-vous déjà pris pour ce coach
$rdv = $pdo->prepare("SELECT date_rdv, heure_rdv FROM rdv WHERE nom_coach = ?");
$rdv->execute([$coach]);
$reserved = $rdv->fetchAll(PDO::FETCH_ASSOC);

// déterminer la durée du créneau : 2h pour certains sports, sinon 1h
$sports_2h = ['football', 'tennis', 'natation'];
// convertir le nom du sport en minuscules pour comparer
$querySport = $pdo->prepare("SELECT sport FROM disponibilities WHERE nom_coach = ? LIMIT 1");
$querySport->execute([$coach]);
$sportRow = $querySport->fetch();
$sport = $sportRow['sport'] ?? '';
$duree_creneau = in_array(strtolower($sport), $sports_2h) ? 2 : 1;
?>

<!-- bouton pour revenir à la liste des sports -->
<a href="browse.php?cat=<?= urlencode($cat ?? 'activites') ?>" class="btn btn-outline-secondary mt-4 ms-3">← Retour</a>

<div class="container mt-4">
    <!-- titre qui affiche le sport -->
    <h2 class="text-center mb-5">Coachs pour <?= htmlspecialchars(ucfirst($sport)) ?></h2>

    <?php foreach ($coachs as $index => $coach): ?>
        <?php
        // récupérer les infos du coach
        $nom = $coach['nom_coach'];
        $photo = $coach['photo'] ?? 'default.jpg';
        $email = $coach['email'] ?? strtolower(str_replace(' ', '.', $nom)) . '@omnessports.fr';
        $telephone = $coach['telephone'] ?? '01 23 45 67 89';
        $salle = $coach['salle'] ?? 'G-010';
        $description = $coach['description'] ?? '';
        $dispoId = "dispo_$index";

        // récupérer le planning brut du coach
        $stmt = $pdo->prepare("SELECT date_disp, heure_disp FROM disponibilities WHERE nom_coach = ? AND sport = ?");
        $stmt->execute([$nom, $sport]);
        $planning = $stmt->fetchAll();

        // vérifier si un CV existe sous différents formats
        $cvBase = "cv/" . $nom;
        $cvExtensions = ['.jpg', '.jpeg', '.png'];
        $cvPath = 'images_photos/default_cv.png';
        foreach ($cvExtensions as $ext) {
            if (file_exists($cvBase . $ext)) {
                $cvPath = $cvBase . $ext;
                break;
            }
        }
        ?>

        <!-- carte pour chaque coach -->
        <div class="card mb-5 shadow p-4 coach-card">
            <div class="row">
                <div class="col-md-4 text-center">
                    <!-- photo du coach -->
                    <img src="images_photos/coachs/<?= htmlspecialchars($photo) ?>"
                         alt="<?= htmlspecialchars($nom) ?>"
                         class="img-fluid rounded mb-3" style="max-height: 200px;">
                </div>

                <div class="col-md-8">
                    <!-- nom du coach et infos -->
                    <h5><?= htmlspecialchars($nom) ?></h5>
                    <p><strong>Spécialité :</strong> <?= ucfirst(htmlspecialchars($sport)) ?></p>
                    <p><strong>Salle :</strong> <?= htmlspecialchars($salle) ?></p>
                    <p><strong>Téléphone :</strong> <?= htmlspecialchars($telephone) ?></p>
                    <p><strong>Email :</strong> <?= htmlspecialchars($email) ?></p>
                    <?php if ($description): ?>
                        <!-- description du coach s’il existe -->
                        <p class="fst-italic text-muted"><?= nl2br(htmlspecialchars($description)) ?></p>
                    <?php endif; ?>

                    <!-- bouton pour afficher / cacher les disponibilités -->
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-primary px-4 py-2 fw-semibold" onclick="toggleDispo('<?= $dispoId ?>')">
                            Voir les disponibilités
                        </button>
                    </div>

                    <!-- boutons pour contacter ou voir le CV -->
                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="mailto:<?= $email ?>" class="btn btn-outline-primary">Contacter</a>
                        <button class="btn btn-outline-secondary" onclick="window.open('<?= $cvPath ?>', '_blank')">Voir le CV</button>
                    </div>
                </div>
            </div>

            <!-- section cachée des créneaux à réserver -->
            <div id="<?= $dispoId ?>" style="display: none;" class="mt-4">
                <h5 class="mb-3">Réserver un créneau</h5>

                <?php if (!isset($_SESSION['user_id'])): ?>
                    <!-- demander de se connecter si l’utilisateur n’est pas loggué -->
                    <div class="alert alert-warning">Connectez-vous pour réserver un créneau.</div>
                <?php endif; ?>

                <div class="table-responsive mt-3">
                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Heure</th>
                                <?php
                                // on définit les jours de la semaine affichés
                                $jours = ['Monday' => 'Lundi', 'Tuesday' => 'Mardi', 'Wednesday' => 'Mercredi', 'Thursday' => 'Jeudi', 'Friday' => 'Vendredi'];
                                foreach ($jours as $en => $fr) echo "<th>$fr</th>";
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // créer la liste des heures selon la durée du créneau
                            $heures = [];
                            for ($t = 7; $t <= 18 - $duree_creneau + 1; $t += $duree_creneau) {
                                $heures[] = sprintf('%02d:00', $t);
                            }

                            foreach ($heures as $heure) {
                                echo "<tr><th>$heure</th>";
                                foreach (array_keys($jours) as $jour) {
                                    $slot = null;
                                    // parcourir le planning pour trouver un créneau correspondant
                                    foreach ($planning as $d) {
                                        $jourSlot = date("l", strtotime($d['date_disp']));
                                        $heureSlot = substr($d['heure_disp'], 0, 5);
                                        if ($jourSlot === $jour && $heureSlot === $heure) {
                                            $slot = $d;
                                            break;
                                        }
                                    }

                                    if ($slot) {
                                        // vérifier si le créneau est déjà réservé
                                        $isBooked = $pdo->prepare("SELECT * FROM rdv WHERE nom_coach = ? AND sport = ? AND date_rdv = ? AND heure_rdv = ?");
                                        $isBooked->execute([$nom, $sport, $slot['date_disp'], $slot['heure_disp']]);
                                        $isReserved = $isBooked->rowCount() > 0;

                                        if ($isReserved) {
                                            // case en bleu si déjà réservé
                                            echo "<td style='background-color: #007BFF;'>&nbsp;</td>";
                                        } else {
                                            if (isset($_SESSION['user_id'])) {
                                                // case blanche cliquable si dispo et connecté
                                                echo "<td style='background-color: white; cursor: pointer;' onclick=\"reserver('{$nom}','{$sport}','{$slot['date_disp']}','{$slot['heure_disp']}', this)\"></td>";
                                            } else {
                                                // case blanche non cliquable si non connecté
                                                echo "<td style='background-color: white;'>&nbsp;</td>";
                                            }
                                        }
                                    } else {
                                        // case noire si pas de créneau prévu
                                        echo "<td style='background-color: black;'>&nbsp;</td>";
                                    }
                                }
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- légende des couleurs -->
                    <div class="mt-2 small text-center">⚪ Disponible | 🟦 Réservé | ⚫ Indisponible</div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
// fonction pour basculer l’affichage de la section disponibilités
function toggleDispo(id) {
    const section = document.getElementById(id);
    section.style.display = section.style.display === "none" ? "block" : "none";
}

// fonction pour envoyer la réservation en AJAX
function reserver(coach, sport, date, heure, cell) {
    if (confirm(`Confirmer le RDV avec ${coach} le ${date} à ${heure} ?`)) {
        fetch('reserver_ajax.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `coach=${encodeURIComponent(coach)}&sport=${encodeURIComponent(sport)}&date=${date}&heure=${heure}`
        })
        .then(res => res.text())
        .then(resp => {
            if (resp === 'success') {
                // si tout va bien, colorer en bleu et désactiver le clic
                cell.style.backgroundColor = '#007BFF';
                cell.onclick = null;
            } else {
                // sinon afficher une alerte
                alert("Erreur : " + resp);
            }
        });
    }
}
</script>

<?php include 'footer.php'; ?>
