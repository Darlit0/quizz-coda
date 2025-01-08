<?php
    session_start();
    require 'includes/database.php';
?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quizz Coda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <?php include '_partials/navbar.php'; ?>

    <div class="container" style="margin-top: 20px;">
        <?php require 'view/quiz.php'; ?>
    </div>

</body>