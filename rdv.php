<?php
// démarrer la session pour récupérer l'id de l'utilisateur
session_start();
// inclure le fichier de connexion à la base de données
require_once 'includes/db.php';

// si l'utilisateur n'est pas connecté, on redirige vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// on récupère l'id de l'utilisateur depuis la session
$user_id = $_SESSION['user_id'];

// récupérer tous les RDV avec un coach pour cet utilisateur
$stmtCoach = $pdo->prepare("SELECT * FROM rdv WHERE user_id = ?");
$stmtCoach->execute([$user_id]);
$rdvsCoach = $stmtCoach->fetchAll();

// récupérer tous les RDV avec la salle de sport pour cet utilisateur
$stmtSalle = $pdo->prepare("SELECT * FROM rdv_salle WHERE user_id = ?");
$stmtSalle->execute([$user_id]);
$rdvsSalle = $stmtSalle->fetchAll();
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Mes rendez-vous</h2>

    <h4 class="mb-3">🧑‍🏫 Coachs</h4>
    <?php if (empty($rdvsCoach)): ?>
        <!-- si aucun RDV coach, on affiche un message -->
        <p class="text-muted">Aucun rendez-vous avec un coach.</p>
    <?php else: ?>
        <!-- sinon, on affiche la liste des RDV coach -->
        <table class="table table-striped text-center">
            <thead class="table-primary">
                <tr>
                    <th>Coach</th>
                    <th>Sport</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rdvsCoach as $r): ?>
                    <tr id="rdv-coach-<?= $r['id'] ?>">
                        <!-- afficher le nom du coach -->
                        <td><?= htmlspecialchars($r['nom_coach']) ?></td>
                        <!-- afficher le sport -->
                        <td><?= htmlspecialchars($r['sport']) ?></td>
                        <!-- afficher la date du RDV -->
                        <td><?= htmlspecialchars($r['date_rdv']) ?></td>
                        <!-- afficher l'heure du RDV sans les secondes -->
                        <td><?= substr($r['heure_rdv'], 0, 5) ?></td>
                        <td>
                            <!-- bouton pour annuler ce RDV -->
                            <button class="btn btn-danger btn-sm" onclick="annulerRDV(<?= $r['id'] ?>, 'coach')">Annuler</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <h4 class="mt-5 mb-3">🏋️‍♂️ Salle de Sport</h4>
    <?php if (empty($rdvsSalle)): ?>
        <!-- si aucun RDV salle, on affiche un message -->
        <p class="text-muted">Aucun rendez-vous avec la salle de sport.</p>
    <?php else: ?>
        <!-- sinon, on affiche la liste des RDV salle -->
        <table class="table table-striped text-center">
            <thead class="table-secondary">
                <tr>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rdvsSalle as $r): ?>
                    <tr id="rdv-salle-<?= $r['id'] ?>">
                        <!-- afficher la date du RDV -->
                        <td><?= htmlspecialchars($r['date_rdv']) ?></td>
                        <!-- afficher l'heure du RDV sans les secondes -->
                        <td><?= substr($r['heure_rdv'], 0, 5) ?></td>
                        <td>
                            <!-- bouton pour annuler ce RDV -->
                            <button class="btn btn-danger btn-sm" onclick="annulerRDV(<?= $r['id'] ?>, 'salle')">Annuler</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<script>
// fonction JavaScript pour annuler un RDV en Ajax
function annulerRDV(id, type) {
    // demander confirmation avant d'annuler
    if (!confirm("Confirmer l'annulation du rendez-vous ?")) return;

    fetch("annuler_rdv.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        // on envoie l'id du RDV et le type (coach ou salle)
        body: `id=${id}&type=${type}`
    })
    .then(r => r.text())
    .then(rep => {
        if (rep === 'success') {
            // si tout s'est bien passé, on supprime la ligne du tableau
            document.getElementById('rdv-' + type + '-' + id).remove();
            alert("Rendez-vous annulé.");
        } else {
            // sinon, on affiche un message d'erreur
            alert("Erreur : " + rep);
        }
    });
}
</script>

<?php include 'footer.php'; ?>
