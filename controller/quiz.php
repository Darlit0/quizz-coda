<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../includes/database.php';
require_once '../model/quiz.php';

$quizzes = getAllQuizzes($pdo);

require '../view/quiz.php';
?>