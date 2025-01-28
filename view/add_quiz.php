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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_quiz = $_POST['name_quiz'];
    $description = $_POST['description'];
    $creator = $_POST['creator'];
    $categorie = $_POST['categorie'];
    $enabled = $_POST['enabled'];
    $questions = isset($_POST['questions']) ? $_POST['questions'] : [];

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO quiz (name_quiz, description, creator, categorie, enabled) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name_quiz, $description, $creator, $categorie, $enabled]);
        $quiz_id = $pdo->lastInsertId();

        $stmtQuestion = $pdo->prepare("INSERT INTO questions (quiz_id, question, good_response, bad_responses, point) VALUES (?, ?, ?, ?, ?)");
        foreach ($questions as $question_data) {
            $stmtQuestion->execute([$quiz_id, $question_data['question'], $question_data['good_response'], $question_data['bad_responses'], $question_data['point'] ?? 1]);
        }

        $pdo->commit();
        header('Location: list.php?success=1');
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Failed: " . $e->getMessage();
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
    <title>Ajouter un Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php require '../_partials/navbar.php'; ?>
    <div class="container mt-5">
        <h1>Ajouter un Quiz</h1>
        <form action="../controller/add_quiz.php" method="POST">
            <div class="mb-3">
                <label for="name_quiz" class="form-label">Nom du Quiz</label>
                <input type="text" class="form-control" id="name_quiz" name="name_quiz" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="creator" class="form-label">Auteur</label>
                <input type="text" class="form-control" id="creator" name="creator" required>
            </div>
            <div class="mb-3">
                <label for="categorie" class="form-label">Catégorie</label>
                <select class="form-control" id="categorie" name="categorie" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['name']) ?>"><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="enabled" class="form-label">Activer</label>
                <select class="form-control" id="enabled" name="enabled" required>
                    <option value="1">Oui</option>
                    <option value="0">Non</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="question" class="form-label">Question</label>
                <input type="text" class="form-control" id="question" placeholder="Entrez une question">
            </div>
            <div class="mb-3">
                <button type="button" class="btn btn-secondary" id="add-question">Ajouter une question</button>
            </div>
            <ol class="list-group list-group-numbered" id="question-list"></ol>
            <div class="mb-3 d-flex justify-content-end mt-3">
                <div class="d-grid gap-2 d-md-block">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </div>
        </form>
    </div>

    <script src="../assets/js/services/add_quiz.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></script>
</body>
</html>