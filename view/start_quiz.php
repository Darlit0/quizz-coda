<?php
session_start();
require "../includes/database.php";

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    $previousPage = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    header("Location: $previousPage");
    exit();
}

$quiz_id = $_GET['quiz_id'] ?? null;
$questions = [];
$quiz = null;

if ($quiz_id) {

    $query = "SELECT * FROM quiz WHERE id = :quiz_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
    $stmt->execute();
    $quiz = $stmt->fetch(PDO::FETCH_ASSOC);

    $query = "SELECT * FROM questions WHERE quiz_id = :quiz_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
    $stmt->execute();
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quiz Coda</title>
    <link rel="icon" type="image/png" href="img/quiz.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <?php include '../_partials/navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-4"><?= htmlspecialchars($quiz['name_quiz']) ?></h1>
        <?php if ($quiz_id && !empty($questions)): ?>
            <form method="POST" action="submit_quiz.php">
                <div class="accordion" id="accordionExample">
                    <?php foreach ($questions as $index => $question): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button <?= $index === 0 ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $index ?>">
                                    <?= htmlspecialchars($question['question']) ?>
                                </button>
                            </h2>
                            <div id="collapse<?= $index ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div>
                                        <input type="radio" name="question_<?= $question['id'] ?>" value="<?= htmlspecialchars($question['good_response']) ?>" required> <?= htmlspecialchars($question['good_response']) ?><br>
                                        <?php foreach (explode(',', $question['bad_responses']) as $bad_response): ?>
                                            <input type="radio" name="question_<?= $question['id'] ?>" value="<?= htmlspecialchars(trim($bad_response)) ?>" required> <?= htmlspecialchars(trim($bad_response)) ?><br>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Soumettre</button>
            </form>
        <?php else: ?>
            <div class="alert alert-warning">Aucun quiz n'est disponible.</div>
        <?php endif; ?>
    </div>

    <script src="includes/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/services/quiz.js"></script>
</body>
</html>