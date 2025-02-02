<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../includes/database.php';

$quiz_id = $_GET['quiz_id'] ?? null;

if (!$quiz_id) {
    echo "ID de quiz non fourni.";
    exit();
}

$quiz = null;
$questions = [];

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
<?php require '../_partials/header.php'; ?>

<body>

    <?php include '../_partials/navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-4"><?= htmlspecialchars($quiz['name_quiz']) ?></h1>
        <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar bg-success" id="progressBar" style="width: 0%">0%</div>
        </div>
        <?php if ($quiz_id && !empty($questions)): ?>
            <form id="quiz-form" action="../view/submit_quiz.php" method="POST">
                <input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">
                <div class="accordion accordion-flush" id="accordionExample">
                    <?php foreach ($questions as $index => $question): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button <?= $index === 0 ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $index ?>">
                                    <?= htmlspecialchars($question['question']) ?>
                                </button>
                            </h2>
                            <div id="collapse<?= $index ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="quiz-form">
                                        <?php
                                        $responses = array_merge(
                                            [htmlspecialchars($question['good_response'])],
                                            array_map('htmlspecialchars', explode(',', $question['bad_responses']))
                                        );
                                        shuffle($responses);
                                        ?>
                                        <?php foreach ($responses as $response): ?>
                                            <input type="radio" name="question_<?= $question['id'] ?>" value="<?= $response ?>" required> <?= $response ?><br>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Soumettre</button>
            </form>
            <div id="result" class="mt-4"></div>
        <?php else: ?>
            <div class="alert alert-warning">Aucune question disponible pour ce quiz.</div>
        <?php endif; ?>
    </div>

    <script src="../assets/js/services/start_quiz.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></script>
</body>
</html>