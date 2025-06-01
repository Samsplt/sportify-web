<?php
// on lance la session pour garder les infos
session_start();
// on inclut le fichier de connexion à la base de données
require_once 'includes/db.php';

// on initialise la variable d’erreur vide
$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // on récupère les valeurs envoyées par le formulaire (ou chaîne vide si non définies)
    $email = $_POST['email'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';

    // on vérifie que l’email et le mot de passe ne sont pas vides
    if (!empty($email) && !empty($mot_de_passe)) {
        // on prépare et exécute la requête pour récupérer l’utilisateur selon l’email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // si on a bien trouvé un utilisateur et que le mot de passe correspond
        if ($user && password_verify($mot_de_passe, $user['password'])) {
            // on stocke l’id, le nom et le type de compte dans la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nom'];
            $_SESSION['user_type'] = $user['type_compte'];

            // selon le type de compte, on redirige vers le bon tableau de bord
            if ($user['type_compte'] === 'admin') {
                header('Location: admin_dashboard.php');
            } elseif ($user['type_compte'] === 'coach') {
                header('Location: coach_dashboard.php');
            } else {
                header('Location: index.php');
            }
            exit;
        } else {
            // si l’utilisateur n’existe pas ou que le mot de passe est faux
            $erreur = "Identifiants invalides.";
        }
    } else {
        // si l’un des champs est vide
        $erreur = "Veuillez remplir tous les champs.";
    }
}
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Connexion à Sportify</h2>

    <?php if ($erreur): ?>
        <!-- affichage du message d’erreur si besoin -->
        <div class="alert alert-danger text-center"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <!-- formulaire de connexion centré -->
    <form method="POST" class="mx-auto" style="max-width: 400px;">
        <div class="mb-3">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="mot_de_passe" class="form-label">Mot de passe</label>
            <input type="password" name="mot_de_passe" id="mot_de_passe" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Se connecter</button>
    </form>

    <p class="text-center mt-3">
        Pas encore de compte ? <a href="register.php">Créer un compte</a>
    </p>
</div>

<?php include 'footer.php'; ?>
