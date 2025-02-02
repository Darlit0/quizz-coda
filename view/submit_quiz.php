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
<?php require '../_partials/header.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<body>

    <?php include '../_partials/navbar.php'; ?>

    <div class="container mt-5">
        <?php if ($quiz): ?>
            <h1 class="mb-4">Résultats du Quiz : <?= htmlspecialchars($quiz['name_quiz']) ?></h1>
            <div class="alert alert-success">Votre score est de <?= $correctAnswers ?> / <?= count($questions) ?></div>
            <canvas id="resultsChart" style="width: 200px; height: 200px;"></canvas> <!-- Taille ajustée via CSS -->
        <?php else: ?>
            <div class="alert alert-warning">Quiz non trouvé.</div>
        <?php endif; ?>
    </div>

    <script>
        const correctAnswers = <?= $correctAnswers ?>;
        const wrongAnswers = <?= $wrongAnswers ?>;

        const data = {
            labels: ['Correct', 'Incorrect'],
            datasets: [{
                data: [correctAnswers, wrongAnswers],
                backgroundColor: ['#4CAF50', '#F44336']
            }]
        };

        const config = {
            type: 'doughnut',
            data: data,
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
        };

        const ctx = document.getElementById('resultsChart').getContext('2d');
        const resultsChart = new Chart(ctx, config);
    </script>
    <script src="../assets/js/services/submit_quiz.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></script>
</body>
</html>