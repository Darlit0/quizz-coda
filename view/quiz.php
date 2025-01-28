<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "./includes/database.php";

$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

$query = $is_admin ? "SELECT * FROM quiz" : "SELECT * FROM quiz WHERE enabled = 1";
$quizzes = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quiz Coda</title>
    <link rel="icon" type="image/png" href="img/quiz.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

    <?php include './_partials/navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-4">Sélectionnez un quiz</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php if (!empty($quizzes)): ?>
                <?php foreach ($quizzes as $quiz): ?>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($quiz['name_quiz']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($quiz['description']) ?></p>
                            </div>
                            <div class="card-footer d-grid gap-2">
                                <a href="view/start_quiz.php?quiz_id=<?= $quiz['id'] ?>" class="btn btn-success">Commencer</a>
                                <div class="d-flex justify-content-between">
                                    <small class="text-body-secondary">Catégorie : <?= htmlspecialchars($quiz['categorie']) ?></small>
                                    <small class="text-body-secondary">Auteur : <?= htmlspecialchars($quiz['creator']) ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="container mt-5">
                    <div class="alert alert-warning d-flex justify-content-center">Aucun quiz disponible pour le moment.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="includes/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/services/quiz.js"></script>
</body>
</html>