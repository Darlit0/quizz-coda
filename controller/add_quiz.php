<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../includes/database.php';
require_once '../model/add_quiz.php';

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

    $success = addQuiz($pdo, $name_quiz, $description, $creator, $categorie, $enabled, $questions);
    if ($success) {
        header('Location: list.php?success=1');
        exit();
    } else {
        echo "Failed to add quiz.";
    }
}

$categories = getCategories($pdo);
require '../view/add_quiz.php';
?>