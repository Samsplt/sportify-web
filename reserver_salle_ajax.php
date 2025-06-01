<?php
// on démarre la session pour récupérer l'id utilisateur
session_start();
// on inclut la connexion à la base de données
require_once 'includes/db.php';

// si l'utilisateur n'est pas connecté, on renvoie une erreur
if (!isset($_SESSION['user_id'])) {
    echo 'not_logged_in';
    exit;
}

// on récupère l'id de l'utilisateur depuis la session
$userId = $_SESSION['user_id'];
// on récupère la date et l'heure envoyées par la requête AJAX
$date = $_POST['date'] ?? '';
$heure = $_POST['heure'] ?? '';

// si la date ou l'heure manque, on renvoie une erreur
if (!$date || !$heure) {
    echo 'missing_data';
    exit;
}

// on vérifie si le créneau est déjà réservé dans la table rdv_salle
$check = $pdo->prepare("SELECT * FROM rdv_salle WHERE date_rdv = ? AND heure_rdv = ?");
$check->execute([$date, $heure]);

// si on trouve déjà un enregistrement, le créneau est pris
if ($check->rowCount() > 0) {
    echo 'already_booked';
    exit;
}

// sinon on peut insérer la réservation
$insert = $pdo->prepare("INSERT INTO rdv_salle (user_id, date_rdv, heure_rdv) VALUES (?, ?, ?)");
if ($insert->execute([$userId, $date, $heure])) {
    // tout s'est bien passé
    echo 'success';
} else {
    // s'il y a un problème à l'insertion
    echo 'error';
}
?>```
