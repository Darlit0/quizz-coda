<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../includes/database.php';
require_once '../model/start_quiz.php';

$quiz_id = $_GET['quiz_id'] ?? null;

if (!$quiz_id) {
    echo "ID de quiz non fourni.";
    exit();
}

$quiz = getQuizById($pdo, $quiz_id);
$questions = getQuestionsByQuizId($pdo, $quiz_id);

require '../view/start_quiz.php';
?>