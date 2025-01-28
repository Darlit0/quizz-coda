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

$quiz_id = $_GET['quiz_id'] ?? $_POST['quiz_id'] ?? null;
$questions = [];
$quiz = null;
$correctAnswers = 0;
$wrongAnswers = 0;

if ($quiz_id) {
    $query = "SELECT * FROM quiz WHERE id = :quiz_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
    $stmt->execute();
    $quiz = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($quiz) {
        $query = "SELECT * FROM questions WHERE quiz_id = :quiz_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
        $stmt->execute();
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($questions as $question) {
            $userAnswer = $_POST['question_' . $question['id']] ?? null;
            if ($userAnswer === $question['good_response']) {
                $correctAnswers++;
            } else {
                $wrongAnswers++;
            }
        }
    } else {
        echo "Quiz non trouvé.";
        exit;
    }
} else {
    echo "ID de quiz non fourni.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Résultats du Quiz</title>
    <link rel="icon" type="image/png" href="img/quiz.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <?php include '../_partials/navbar.php'; ?>

    <div class="container mt-5">
        <?php if ($quiz): ?>
            <h1 class="mb-4">Résultats du Quiz : <?= htmlspecialchars($quiz['name_quiz']) ?></h1>
            <div class="alert alert-success">Bonnes réponses : <?= $correctAnswers ?></div>
            <div class="alert alert-danger">Mauvaises réponses : <?= $wrongAnswers ?></div>
            <canvas id="resultsChart" width="400" height="400"></canvas>
        <?php else: ?>
            <div class="alert alert-warning">Quiz non trouvé.</div>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('resultsChart').getContext('2d');
            const resultsChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Bonnes réponses', 'Mauvaises réponses'],
                    datasets: [{
                        label: 'Résultats du Quiz',
                        data: [<?= $correctAnswers ?>, <?= $wrongAnswers ?>],
                        backgroundColor: ['#28a745', '#dc3545'],
                        borderColor: ['#28a745', '#dc3545'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Résultats du Quiz'
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>