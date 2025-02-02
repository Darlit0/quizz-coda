<?php
require '../includes/database.php';
require '../_partials/errors.php';
session_start();

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: ../index.php');
    exit();
}

$quiz_id = $_GET['quiz_id'] ?? null;

if (!$quiz_id) {
    echo "ID de quiz non fourni.";
    exit();
}

$query = "SELECT * FROM quiz WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->bindParam(1, $quiz_id, PDO::PARAM_INT);
$stmt->execute();
$quiz = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$quiz) {
    echo "<p>Quiz non trouvé.</p>";
    exit();
}

$queryQuestions = "SELECT * FROM questions WHERE quiz_id = ?";
$stmtQuestions = $pdo->prepare($queryQuestions);
$stmtQuestions->bindParam(1, $quiz_id, PDO::PARAM_INT);
$stmtQuestions->execute();
$questions = $stmtQuestions->fetchAll(PDO::FETCH_ASSOC);

$queryCategories = "SELECT * FROM category";
$stmtCategories = $pdo->prepare($queryCategories);
$stmtCategories->execute();
$categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require '../_partials/header.php'; ?>

<body>
    <?php include '../_partials/navbar.php'; ?>
    <div class="container mt-5">
        <h1>Modifier le Quiz</h1>
        <form action="../controller/modified_quiz.php?quiz_id=<?= $quiz_id ?>" method="POST">
            <div class="mb-3">
                <label for="name_quiz" class="form-label">Nom du Quiz</label>
                <input type="text" class="form-control" id="name_quiz" name="name_quiz" value="<?= htmlspecialchars($quiz['name_quiz']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($quiz['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="enabled" class="form-label">Activer</label>
                <select class="form-control" id="enabled" name="enabled" required>
                    <option value="1" <?= $quiz['enabled'] == 1 ? 'selected' : '' ?>>Oui</option>
                    <option value="0" <?= $quiz['enabled'] == 0 ? 'selected' : '' ?>>Non</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Catégorie</label>
                <select class="form-control" name="questions[<?= $question['id'] ?>][category_id]" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= isset($question['category_id']) && $question['category_id'] == $category['id'] ? 'selected' : '' ?>><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <ol class="list-group list-group-numbered" id="questions">
                <?php foreach ($questions as $index => $question): ?>
                    <li class="list-group-item mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" class="form-control" name="questions[<?= $question['id'] ?>][question]" value="<?= htmlspecialchars($question['question']) ?>" required>
                        <label class="form-label">Bonne réponse</label>
                        <input type="text" class="form-control" name="questions[<?= $question['id'] ?>][good_response]" value="<?= htmlspecialchars($question['good_response']) ?>" required>
                        <label class="form-label">Mauvaises réponses (séparées par des virgules)</label>
                        <input type="text" class="form-control" name="questions[<?= $question['id'] ?>][bad_responses]" value="<?= htmlspecialchars($question['bad_responses']) ?>" required>
                        <label class="form-label">Points</label>
                        <input type="number" class="form-control" name="questions[<?= $question['id'] ?>][point]" value="<?= htmlspecialchars($question['point']) ?>" required>
                    </li>
                <?php endforeach; ?>
            </ol>
            <button type="button" id="add-question" class="btn btn-secondary">Ajouter une question</button>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>

    <script>
        const categoriesOptionsHtml = `<?php foreach ($categories as $category): ?>
            <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
        <?php endforeach; ?>`;
    </script>
    <script src="../assets/js/services/modified_quiz.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></script>
</body>
</html>