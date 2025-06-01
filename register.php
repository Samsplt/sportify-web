<?php
// on inclut la connexion à la base de données
require_once 'includes/db.php';
// on démarre la session pour gérer les messages d'erreur ou de succès
session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // on récupère et nettoie les données du formulaire
    $nom      = trim($_POST['nom'] ?? '');
    $prenom   = trim($_POST['prenom'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role     = $_POST['role'] ?? 'client';

    // on vérifie que tous les champs sont remplis
    if (!$nom || !$prenom || !$email || !$password || !$role) {
        $error = "Tous les champs sont requis.";
    } else {
        // on vérifie que l’email n’est pas déjà utilisé
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {
            // si l’email existe déjà, on affiche une erreur
            $error = "Un compte existe déjà avec cet e-mail.";
        } else {
            // on crée un hash du mot de passe pour la sécurité
            $hash = password_hash($password, PASSWORD_DEFAULT);
            // on insère le nouvel utilisateur dans la table users
            $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$nom, $prenom, $email, $hash, $role])) {
                // si l’insertion réussit, on prépare le message de succès puis on redirige vers la page de connexion
                $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                header("Location: login.php");
                exit;
            } else {
                // si l’insertion échoue, on affiche une erreur générique
                $error = "Erreur lors de l'inscription.";
            }
        }
    }
}
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Inscription</h2>

    <!-- on affiche le message d'erreur si besoin -->
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- on affiche le message de succès si l'inscription a fonctionné -->
    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <!-- formulaire d'inscription -->
    <form method="post" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Prénom</label>
            <input type="text" name="prenom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Type de compte</label>
            <select name="role" class="form-select" required>
                <!-- on propose différents rôles pour l'utilisateur -->
                <option value="client">Client</option>
                <option value="coach">Coach</option>
                <option value="admin">Administrateur</option>
            </select>
        </div>

        <!-- bouton pour valider l'inscription -->
        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
</div>

<?php include 'footer.php'; ?>
