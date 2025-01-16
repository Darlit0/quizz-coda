<?php
session_start();
require '../includes/database.php';

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: ../index.php');
    exit();
}

require "../_partials/errors.php";
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

    <?php include '../_partials/navbar.php'; ?>

    <?php if (!empty($quizzes)): ?>
        <?php foreach ($quizzes as $quiz): ?>
            <div class="container mt-5">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?= htmlspecialchars($quiz['name_quiz']) ?></h5>
                            <small>3 days ago</small>
                        </div>
                        <small>And some small print.</small>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="container mt-5">
            <div class="alert alert-warning d-flex justify-content-center">Aucun quiz disponible pour le moment.</div>
        </div>
    <?php endif; ?>

    <script src="../includes/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>