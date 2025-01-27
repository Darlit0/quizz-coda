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

// Get quiz ID from URL
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;

if ($quiz_id <= 0) {
    echo "<p>ID de quiz invalide. ID reçu: " . htmlspecialchars($quiz_id) . "</p>";
    exit();
}

// Fetch quiz details from database
$query = "SELECT * FROM quiz WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->bindParam(1, $quiz_id, PDO::PARAM_INT);
$stmt->execute();
$quiz = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$quiz) {
    echo "<p>Quiz non trouvé.</p>";
    exit();
}

// Fetch questions
$queryQuestions = "SELECT * FROM questions WHERE quiz_id = ?";
$stmtQuestions = $pdo->prepare($queryQuestions);
$stmtQuestions->bindParam(1, $quiz_id, PDO::PARAM_INT);
$stmtQuestions->execute();
$questions = $stmtQuestions->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_quiz = $_POST['name_quiz'];
    $description = $_POST['description'];
    $creator = $_POST['creator'];
    $categorie = $_POST['categorie'];
    $enabled = $_POST['enabled'];
    $questions = isset($_POST['questions']) ? $_POST['questions'] : [];

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("UPDATE quiz SET name_quiz = ?, description = ?, creator = ?, categorie = ?, enabled = ? WHERE id = ?");
        $stmt->execute([$name_quiz, $description, $creator, $categorie, $enabled, $quiz_id]);

        $stmtQuestion = $pdo->prepare("UPDATE questions SET question = ?, good_response = ?, bad_responses = ? WHERE id = ?");

        foreach ($questions as $question_id => $question_data) {
            $stmtQuestion->execute([$question_data['question'], $question_data['good_response'], $question_data['bad_responses'], $question_id]);
        }

        $pdo->commit();
        header('Location: list.php?success=1');
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
}

// Fetch categories from the category table
$queryCategories = "SELECT * FROM category";
$stmtCategories = $pdo->prepare($queryCategories);
$stmtCategories->execute();
$categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php require '../_partials/navbar.php'; ?>
    <div class="container mt-5">
        <h1>Modifier le Quiz : <?= htmlspecialchars($quiz['name_quiz']) ?></h1>
        <form action="modified_quiz.php?quiz_id=<?= $quiz_id ?>" method="POST">
            <div class="mb-3">
                <label for="name_quiz" class="form-label">Nom du Quiz</label>
                <input type="text" class="form-control" id="name_quiz" name="name_quiz" value="<?= htmlspecialchars($quiz['name_quiz']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($quiz['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="creator" class="form-label">Auteur</label>
                <input type="text" class="form-control" id="creator" name="creator" value="<?= htmlspecialchars($quiz['creator']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="categorie" class="form-label">Catégorie</label>
                <select class="form-control" id="categorie" name="categorie" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['name']) ?>" <?= isset($quiz['categorie']) && $quiz['categorie'] == $category['name'] ? 'selected' : '' ?>><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="enabled" class="form-label">Activer</label>
                <select class="form-control" id="enabled" name="enabled" required>
                    <option value="1" <?= $quiz['enabled'] ? 'selected' : '' ?>>Oui</option>
                    <option value="0" <?= !$quiz['enabled'] ? 'selected' : '' ?>>Non</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="question" class="form-label">Question</label>
                <input type="text" class="form-control" id="question" placeholder="Entrez une question">
            </div>
            <div class="mb-3">
                <button type="button" class="btn btn-secondary" id="add-question">Ajouter une question</button>
            </div>
            <ol class="list-group list-group-numbered" id="question-list">
                <?php foreach ($questions as $question): ?>
                    <li class="list-group-item">
                        <div class="mb-3">
                            <label for="question_<?= $question['id'] ?>" class="form-label">Question</label>
                            <input type="text" class="form-control" id="question_<?= $question['id'] ?>" name="questions[<?= $question['id'] ?>][question]" value="<?= htmlspecialchars($question['question']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="good_response_<?= $question['id'] ?>" class="form-label">Bonne réponse</label>
                            <input type="text" class="form-control" id="good_response_<?= $question['id'] ?>" name="questions[<?= $question['id'] ?>][good_response]" value="<?= htmlspecialchars($question['good_response']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="bad_responses_<?= $question['id'] ?>" class="form-label">Mauvaises réponses (séparées par des virgules)</label>
                            <input type="text" class="form-control" id="bad_responses_<?= $question['id'] ?>" name="questions[<?= $question['id'] ?>][bad_responses]" value="<?= htmlspecialchars($question['bad_responses']) ?>" required>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">Supprimer la question</button>
                    </li>
                <?php endforeach; ?>
            </ol>
            <div class="mb-3 d-flex justify-content-end mt-3">
                <div class="d-grid gap-2 d-md-block">
                    <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('add-question').addEventListener('click', function() {
            var questionInput = document.getElementById('question');
            var questionText = questionInput.value.trim();

            if (questionText !== '') {
                var questionList = document.getElementById('question-list');
                var newQuestionItem = document.createElement('li');
                newQuestionItem.className = 'list-group-item';

                var questionHeader = document.createElement('div');
                questionHeader.className = 'mb-3';
                questionHeader.innerHTML = '<label for="new_question_' + questionList.children.length + '" class="form-label">Question</label>' +
                                           '<input type="text" class="form-control" id="new_question_' + questionList.children.length + '" name="questions[new_' + questionList.children.length + '][question]" value="' + questionText + '" required>';

                var goodResponseInput = document.createElement('div');
                goodResponseInput.className = 'mb-3';
                goodResponseInput.innerHTML = '<label for="new_good_response_' + questionList.children.length + '" class="form-label">Bonne réponse</label>' +
                                              '<input type="text" class="form-control" id="new_good_response_' + questionList.children.length + '" name="questions[new_' + questionList.children.length + '][good_response]" required>';

                var badResponsesInput = document.createElement('div');
                badResponsesInput.className = 'mb-3';
                badResponsesInput.innerHTML = '<label for="new_bad_responses_' + questionList.children.length + '" class="form-label">Mauvaises réponses (séparées par des virgules)</label>' +
                                              '<input type="text" class="form-control" id="new_bad_responses_' + questionList.children.length + '" name="questions[new_' + questionList.children.length + '][bad_responses]" required>';

                var removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-danger btn-sm';
                removeButton.textContent = 'Supprimer la question';
                removeButton.addEventListener('click', function() {
                    questionList.removeChild(newQuestionItem);
                });

                newQuestionItem.appendChild(questionHeader);
                newQuestionItem.appendChild(goodResponseInput);
                newQuestionItem.appendChild(badResponsesInput);
                newQuestionItem.appendChild(removeButton);

                questionList.appendChild(newQuestionItem);

                // Effacer le champ de saisie après l'ajout
                questionInput.value = '';
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></script>
</body>
</html>