<?php
include 'functions/operations.php';

$userId = 1; // Replace with dynamic user ID
$userPreferences = getUserPreferences($userId, $db);
$suggestions = suggestBooks($userId, $db);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommandations de Livres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; }
        .section { margin: 20px 0; }
        h2 { color: #007bff; }
        .card { margin: 10px 0; }
        .reserve-button { background-color: #28a745; color: white; border: none; padding: 5px 10px; }
        .reserve-button:hover { background-color: #218838; }
    </style>
</head>
<body>

<div class="container mt-4">
    <!-- User Preferences Section -->
    <div class="section">
        <h2>Vos Préférences de Lecture</h2>
        <div class="row">
            <ul class="list-group">
                <?php foreach ($userPreferences as $preference): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><strong>Genre :</strong> <?= $preference['genre'] ?></span>
                        <span><strong>Réservations :</strong> <?= $preference['count'] ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

   <!-- Suggestions by Favorite Genre Section -->
<div class="section">
    <h2>Suggestions pour Vous (par Genre Favori)</h2>
    <?php foreach ($suggestions['by_genre'] as $genre => $books): ?>
        <h3 class="mt-4"><?= $genre ?></h3>
        <div class="row">
            <?php foreach ($books as $book): ?>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $book['title'] ?></h5>
                            <p class="card-text"><strong>Genre :</strong> <?= $book['genre'] ?></p>
                            <form action="reserve.php" method="POST">
                                <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                                <input type="hidden" name="userId" value="<?= $userId; ?>">
                                <button type="submit" class="reserve-button btn">Réserver maintenant</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>

<!-- Suggestions Based on Popularity Section -->
<div class="section">
    <h2>Suggestions Basées sur la Popularité</h2>
    <div class="row">
        <?php foreach ($suggestions['by_popularity'] as $book): ?>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $book['title'] ?></h5>
                        <p class="card-text"><strong>Genre :</strong> <?= $book['genre'] ?></p>
                        <form action="reserve.php" method="POST">
                            <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                            <input type="hidden" name="userId" value="<?= $userId; ?>">
                            <button type="submit" class="reserve-button btn">Réserver maintenant</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
</body>
</html>
