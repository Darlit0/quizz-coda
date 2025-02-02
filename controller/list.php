<?php
session_start();
require '../includes/database.php';
require '../model/list.php';

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $quiz_id = $_POST['quiz_id'] ?? null;

    if ($action && $quiz_id) {
        $quiz_id = (int)$quiz_id;

        if ($action === 'toggle_status') {
            $status = $_POST['status'] ?? null;
            if ($status !== null) {
                $status = (int)$status;
                $success = toggleQuizStatus($pdo, $quiz_id, $status);
                echo json_encode(['success' => $success]);
                exit();
            }
        } elseif ($action === 'delete') {
            $success = deleteQuiz($pdo, $quiz_id);
            echo json_encode(['success' => $success]);
            exit();
        }
    }

    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
}

$quizzes = getAllQuizzes($pdo);
require '../view/list.php';
?>