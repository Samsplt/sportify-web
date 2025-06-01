<?php
// on récupère le nom du fichier depuis l'URL
$file = $_GET['file'] ?? '';
// on sécurise le chemin pour éviter les traversals
$path = 'cv/' . basename($file);

// si aucun fichier demandé ou que le fichier n'existe pas, on affiche un message
if (!$file || !file_exists($path)) {
    echo "<h3 style='text-align:center;margin-top:50px;'>CV introuvable : " . htmlspecialchars($file) . "</h3>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CV de Coach</title>
    <!-- on charge Bootstrap depuis le CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="text-center">
        <!-- titre de la page -->
        <h2 class="mb-4">CV du Coach</h2>
        <!-- on affiche l'image du CV en responsif -->
        <img src="<?= $path ?>" alt="CV Coach" class="img-fluid rounded shadow">
    </div>
</body>
</html>
