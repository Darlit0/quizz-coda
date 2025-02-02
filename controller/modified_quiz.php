<?php
// filepath: /c:/xampp/htdocs/quizz_coda/controller/modified_quiz.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../includes/database.php';
require_once '../model/modified_quiz.php';

$quiz_id = $_GET['quiz_id'] ?? null;

if (!$quiz_id) {
    echo "ID de quiz non fourni.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_quiz = $_POST['name_quiz'];
    $description = $_POST['description'];
    $enabled = $_POST['enabled'];
    $questions = isset($_POST['questions']) ? $_POST['questions'] : [];

    $success = updateQuiz($pdo, $quiz_id, $name_quiz, $description, $enabled, $questions);
    if ($success) {
        header('Location: list.php?success=1');
        exit();
    } else {
        echo "Failed to update quiz.";
    }
}

$quiz = getQuizById($pdo, $quiz_id);
$questions = getQuestionsByQuizId($pdo, $quiz_id);

require '../view/modified_quiz.php';
?>