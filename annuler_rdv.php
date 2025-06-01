<?php
// Démarre la session pour récupérer l'id de l'utilisateur
session_start();
// On inclut la connexion à la base de données
require_once 'includes/db.php';

// On vérifie que l'utilisateur est connecté et que l'id du rdv et le type arrivent bien en POST
if (!isset($_SESSION['user_id'], $_POST['id'], $_POST['type'])) {
    echo 'unauthorized';
    exit;
}

// On récupère l'id de l'utilisateur depuis la session
$user_id = $_SESSION['user_id'];
// On récupère l'id du rdv et le type (coach ou salle) depuis le formulaire
$id = $_POST['id'];
$type = $_POST['type'];

// On teste si le type est bien 'coach' ou 'salle'
if (!in_array($type, ['coach', 'salle'])) {
    echo 'invalid_type';
    exit;
}

// En fonction du type, on choisit la table dans la BDD
$table = $type === 'coach' ? 'rdv' : 'rdv_salle';

// On prépare une requête pour s'assurer que le rdv appartient bien à l'utilisateur
$check = $pdo->prepare("SELECT * FROM $table WHERE id = ? AND user_id = ?");
$check->execute([$id, $user_id]);
// Si on ne trouve pas de résultat, on arrête tout
if ($check->rowCount() === 0) {
    echo 'not_found';
    exit;
}

// Si la vérification est OK, on peut supprimer le rdv
$delete = $pdo->prepare("DELETE FROM $table WHERE id = ? AND user_id = ?");
$delete->execute([$id, $user_id]);

// On renvoie 'success' pour dire que tout s'est bien passé
echo 'success';
