<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "not_connected";
    exit;
}

$coach = $_POST['coach'] ?? '';
$sport = $_POST['sport'] ?? '';
$date = $_POST['date'] ?? '';
$heure = $_POST['heure'] ?? '';

if (!$coach || !$sport || !$date || !$heure) {
    echo "missing_data";
    exit;
}

// Vérifie si créneau est encore dispo
$check = $pdo->prepare("SELECT * FROM rdv WHERE nom_coach = ? AND sport = ? AND date_rdv = ? AND heure_rdv = ?");
$check->execute([$coach, $sport, $date, $heure]);

if ($check->rowCount() > 0) {
    echo "already_booked";
    exit;
}

// Enregistre le RDV
$insert = $pdo->prepare("INSERT INTO rdv (user_id, nom_coach, sport, date_rdv, heure_rdv) VALUES (?, ?, ?, ?, ?)");
$insert->execute([$_SESSION['user_id'], $coach, $sport, $date, $heure]);

echo "success";
