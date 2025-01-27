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
        <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar bg-success" id="progressBar" style="width: 0%">0%</div>
        </div>
        <?php if ($quiz_id && !empty($questions)): ?>
            <form method="POST" action="submit_quiz.php" id="quizForm">
                <div id="questionOrder">
                    <?php foreach ($questions as $index => $question): ?>
                        <div class="question-item" data-index="<?= $index ?>">
                            <span><?= htmlspecialchars($question['question']) ?></span>
                            <button type="button" class="btn btn-success move-up">↑</button>
                            <button type="button" class="btn btn-danger move-down">↓</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-primary" id="startQuiz">Lancer le quiz</button>
                <div class="accordion accordion-flush d-none" id="accordionExample">
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
                                        <?php
                                        $responses = array_merge(
                                            [$question['good_response']],
                                            explode(',', $question['bad_responses'])
                                        );
                                        shuffle($responses);
                                        ?>
                                        <?php foreach ($responses as $response): ?>
                                            <input type="radio" name="question_<?= $question['id'] ?>" value="<?= htmlspecialchars(trim($response)) ?>" required> <?= htmlspecialchars(trim($response)) ?><br>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-warning">Aucune question trouvée pour ce quiz.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const questionOrder = document.getElementById('questionOrder');
            const startQuizButton = document.getElementById('startQuiz');
            const accordionExample = document.getElementById('accordionExample');

            questionOrder.addEventListener('click', function(event) {
                if (event.target.classList.contains('move-up')) {
                    const item = event.target.closest('.question-item');
                    if (item.previousElementSibling) {
                        questionOrder.insertBefore(item, item.previousElementSibling);
                    }
                } else if (event.target.classList.contains('move-down')) {
                    const item = event.target.closest('.question-item');
                    if (item.nextElementSibling) {
                        questionOrder.insertBefore(item.nextElementSibling, item);
                    }
                }
            });

            startQuizButton.addEventListener('click', function() {
                const orderedQuestions = Array.from(questionOrder.children).map(item => item.dataset.index);
                const accordionItems = Array.from(accordionExample.children);
                orderedQuestions.forEach(index => {
                    accordionExample.appendChild(accordionItems[index]);
                });
                questionOrder.classList.add('d-none');
                startQuizButton.classList.add('d-none');
                accordionExample.classList.remove('d-none');
            });

            const accordion = document.getElementById('accordionExample');
            const progressBar = document.getElementById('progressBar');
            const totalQuestions = <?= count($questions) ?>;
            let answeredQuestions = 0;

            accordion.addEventListener('change', function(event) {
                if (event.target.type === 'radio') {
                    const currentItem = event.target.closest('.accordion-item');
                    const currentCollapse = currentItem.querySelector('.accordion-collapse');
                    const nextItem = currentItem.nextElementSibling;
                    if (nextItem) {
                        const nextButton = nextItem.querySelector('.accordion-button');
                        const nextCollapse = nextItem.querySelector('.accordion-collapse');
                        nextCollapse.classList.add('show');
                        nextButton.classList.remove('collapsed');
                        nextButton.setAttribute('aria-expanded', 'true');
                    }
                    currentCollapse.classList.remove('show');

                    // Mettre à jour la barre de progression
                    answeredQuestions++;
                    const progress = (answeredQuestions / totalQuestions) * 100;
                    progressBar.style.width = progress + '%';
                    progressBar.textContent = Math.round(progress) + '%';
                }
            });
        });
    </script>
</body>
</html>